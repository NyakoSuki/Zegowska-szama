<?php
session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

// --- obsługa POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)$_POST['order_id'];
    $status = $_POST['status'] ?? '';

    if (in_array($status, ['pending', 'ready', 'claimed', 'canceled'])) {
        if ($status === 'claimed' || $status === 'canceled') {
            $connection->query("DELETE FROM ordered_products WHERE order_id = $id");
            $connection->query("DELETE FROM orders WHERE id = $id");
        } else {
            $stmt = $connection->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- pobierz zamówienia ---
$result = $connection->query("
    SELECT o.id AS order_id, o.name AS customer_name, o.email,
           o.total_price, o.status, o.created_at,
           op.product_id, op.name AS product_name,
           op.price AS product_price, op.quantity,
           (op.price * op.quantity) AS product_total
    FROM orders o
    LEFT JOIN ordered_products op ON o.id = op.order_id
    ORDER BY o.created_at DESC
");

$orders = [];
while ($row = $result->fetch_assoc()) {
    $oid = $row['order_id'];
    if (!isset($orders[$oid])) {
        $orders[$oid] = [
            'order_id'      => $oid,
            'customer_name' => $row['customer_name'],
            'email'         => $row['email'],
            'total_price'   => $row['total_price'],
            'status'        => $row['status'],
            'created_at'    => $row['created_at'],
            'products'      => [],
        ];
    }
    if ($row['product_id']) {
        $orders[$oid]['products'][] = $row;
    }
}

$statusLabels = ['pending' => 'Oczekujące', 'ready' => 'Gotowe', 'claimed' => 'Odebrane', 'canceled' => 'Anulowane'];
$nextStep = ['pending' => 'ready', 'ready' => 'claimed'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienia – Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= PUBLIC_URL ?>css/main.css">
    <style>
        #filterBar { position: sticky; top: 0; z-index: 100; background: var(--bs-body-bg,#fff); border-bottom: 1px solid #dee2e6; box-shadow: 0 2px 6px rgba(0,0,0,.06); }
        .order-card[data-status="pending"]  { border-left: 4px solid #ffc107; }
        .order-card[data-status="ready"]    { border-left: 4px solid #0d6efd; }
        .order-card[data-status="claimed"]  { border-left: 4px solid #198754; }
        .order-card[data-status="canceled"] { border-left: 4px solid #dc3545; }
        .badge-pending  { background: #ffc107; color: #000; }
        .badge-ready    { background: #0d6efd; color: #fff; }
        .badge-claimed  { background: #198754; color: #fff; }
        .badge-canceled { background: #dc3545; color: #fff; }
    </style>
</head>
<body class="<?= $_SESSION['theme'] ?>">

<?php
$site = basename($_SERVER['PHP_SELF']);
$folder = basename(__DIR__);
include PUBLIC_PATH . "html/shared/header.php";
?>

<!-- FILTRY -->
<div id="filterBar" class="p-2">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Szukaj: imię, e-mail, nr zamówienia…">
            </div>
            <div class="col-6 col-md-2">
                <input type="number" id="filterMin" class="form-control" step="0.01" min="0" placeholder="Cena min (zł)">
            </div>
            <div class="col-6 col-md-2">
                <input type="number" id="filterMax" class="form-control" step="0.01" min="0" placeholder="Cena max (zł)">
            </div>
            <div class="col-12 col-md-3 d-flex flex-wrap gap-3">
                <?php foreach ($statusLabels as $val => $lbl): ?>
                <div class="form-check">
                    <input class="form-check-input status-filter" type="checkbox" id="f_<?= $val ?>" value="<?= $val ?>" checked>
                    <label class="form-check-label" for="f_<?= $val ?>"><?= $lbl ?></label>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-md-1">
                <button id="resetFilters" class="btn btn-danger w-100">Reset</button>
            </div>
        </div>
    </div>
</div>

<!-- LISTA ZAMÓWIEŃ -->
<section class="container-fluid my-4 px-3">
    <h2 class="mb-3">Zamówienia</h2>
    <p id="noOrdersMsg" class="text-muted fst-italic" style="display:none">Brak wyników.</p>

    <div id="orderList" class="d-flex flex-column gap-3">
    <?php foreach ($orders as $o):
        $oid    = $o['order_id'];
        $status = $o['status'];
    ?>
        <div class="card order-card shadow-sm"
             data-status="<?= $status ?>"
             data-name="<?= strtolower(htmlspecialchars($o['customer_name'])) ?>"
             data-email="<?= strtolower(htmlspecialchars($o['email'])) ?>"
             data-orderid="<?= $oid ?>"
             data-price="<?= (float)$o['total_price'] ?>">

            <div class="card-header d-flex align-items-center gap-2">
                <strong>#<?= $oid ?></strong>
                <span class="badge badge-<?= $status ?> rounded-pill"><?= $statusLabels[$status] ?? $status ?></span>
                <span class="ms-auto text-muted small"><?= $o['created_at'] ?></span>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <!-- info o kliencie -->
                    <div class="col-12 col-md-4">
                        <p class="mb-1"><strong>Klient:</strong> <?= htmlspecialchars($o['customer_name']) ?></p>
                        <p class="mb-1"><strong>E-mail:</strong> <a href="mailto:<?= htmlspecialchars($o['email']) ?>"><?= htmlspecialchars($o['email']) ?></a></p>
                        <p class="mb-0"><strong>Łącznie:</strong> <?= number_format((float)$o['total_price'], 2, ',', ' ') ?> zł</p>
                    </div>

                    <!-- produkty -->
                    <div class="col-12 col-md-5">
                        <table class="table table-sm table-striped mb-0">
                            <thead><tr><th>Produkt</th><th class="text-end">Cena</th><th class="text-end">Ilość</th><th class="text-end">Suma</th></tr></thead>
                            <tbody>
                            <?php foreach ($o['products'] as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                                    <td class="text-end"><?= number_format((float)$p['product_price'], 2, ',', ' ') ?> zł</td>
                                    <td class="text-end"><?= (int)$p['quantity'] ?></td>
                                    <td class="text-end"><?= number_format((float)$p['product_total'], 2, ',', ' ') ?> zł</td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- akcje -->
                    <div class="col-12 col-md-3 d-flex flex-column justify-content-center gap-2">

                        <?php if (isset($nextStep[$status])): ?>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $oid ?>">
                            <input type="hidden" name="status"   value="<?= $nextStep[$status] ?>">
                            <?php if ($nextStep[$status] === 'claimed'): ?>
                            <button type="button"
                                    class="btn btn-success w-100 btn-sm needs-confirm"
                                    data-status="claimed">
                                Oznacz jako odebrane
                            </button>
                            <?php else: ?>
                            <button type="submit" class="btn btn-primary w-100 btn-sm">
                                Oznacz jako gotowe
                            </button>
                            <?php endif; ?>
                        </form>
                        <?php endif; ?>

                        <?php if ($status !== 'canceled' && $status !== 'claimed'): ?>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $oid ?>">
                            <input type="hidden" name="status"   value="canceled">
                            <button type="submit" class="btn btn-danger w-100 btn-sm">
                                Anuluj zamówienie
                            </button>
                        </form>
                        <?php endif; ?>

                        <?php if ($status === 'claimed' || $status === 'canceled'): ?>
                            <span class="text-muted small fst-italic">Brak akcji</span>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($orders)): ?>
        <p class="text-muted fst-italic">Brak zamówień w bazie danych.</p>
    <?php endif; ?>
    </div>
</section>

<!-- Modal potwierdzenia -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zamówienie odebrane</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Oznaczyć zamówienie jako odebrane? Zostanie usunięte z bazy danych.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wróć</button>
                <button type="button" id="confirmModalBtn" class="btn btn-success">Tak, odebrane</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php include BACKEND_PATH . "config/config.js.php" ?>
<script>
// filtry
const cards = document.querySelectorAll('.order-card');
const noMsg = document.getElementById('noOrdersMsg');

function applyFilters() {
    const text = document.getElementById('searchInput').value.toLowerCase().trim();
    const min  = parseFloat(document.getElementById('filterMin').value) || null;
    const max  = parseFloat(document.getElementById('filterMax').value) || null;
    const activeStatuses = [...document.querySelectorAll('.status-filter')]
        .filter(cb => cb.checked).map(cb => cb.value);

    let visible = 0;
    cards.forEach(card => {
        const show = activeStatuses.includes(card.dataset.status)
            && (!text || card.dataset.name.includes(text) || card.dataset.email.includes(text) || card.dataset.orderid.includes(text))
            && (min === null || parseFloat(card.dataset.price) >= min)
            && (max === null || parseFloat(card.dataset.price) <= max);

        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    noMsg.style.display = visible === 0 ? 'block' : 'none';
}

document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('filterMin').addEventListener('input', applyFilters);
document.getElementById('filterMax').addEventListener('input', applyFilters);
document.querySelectorAll('.status-filter').forEach(cb => cb.addEventListener('change', applyFilters));
document.getElementById('resetFilters').addEventListener('click', () => {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterMin').value   = '';
    document.getElementById('filterMax').value   = '';
    document.querySelectorAll('.status-filter').forEach(cb => cb.checked = true);
    applyFilters();
});

// modal potwierdzenia — jeden dla wszystkich przycisków
const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
const confirmBtn   = document.getElementById('confirmModalBtn');
let pendingForm    = null;

document.querySelectorAll('.needs-confirm').forEach(btn => {
    btn.addEventListener('click', () => {
        pendingForm = btn.closest('form');
        confirmModal.show();
    });
});

confirmBtn.addEventListener('click', () => {
    if (pendingForm) pendingForm.submit();
});
</script>

</body>
</html>