<?php
// order.php – główny widok panelu zamówień (admin)

session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

require_once BACKEND_PATH . "admin/orderGenerate.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

// --- pobierz zamówienia ---
$result = $connection->query("
    SELECT o.id          AS order_id,
           o.name        AS customer_name,
           o.email,
           o.total_price,
           o.status,
           o.created_at,
           op.product_id,
           op.name       AS product_name,
           op.price      AS product_price,
           op.quantity,
           (op.price * op.quantity) AS product_total
    FROM orders o
    LEFT JOIN ordered_products op ON o.id = op.order_id
    ORDER BY o.created_at DESC
");

$orders = [];
while ($row = $result->fetch_assoc()) {
    $oid = (int)$row['order_id'];
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
    if ($row['product_id'] !== null) {
        $orders[$oid]['products'][] = [
            'product_id'    => $row['product_id'],
            'product_name'  => $row['product_name'],
            'product_price' => $row['product_price'],
            'quantity'      => $row['quantity'],
            'product_total' => $row['product_total'],
        ];
    }
}
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
$site   = basename($_SERVER['PHP_SELF']);
$folder = basename(__DIR__);
include PUBLIC_PATH . "html/shared/header.php";
?>


<section>
    <div id="filters" class="filterDisabled col-12 col-sm-6 col-lg-4 col-xxl-4 h-75 overflow-auto">
        <div class="card bg-white">
            <div class="card-body">

                <h6 class="mb-3 fw-bold">Filtry zamówień</h6>

                <!-- Wyszukiwarka -->
                <label class="form-label small fw-semibold">Szukaj</label>
                <input type="text" id="searchInput" class="form-control bg-light mb-3"
                       placeholder="Nazwa, e-mail lub nr zamówienia">

                <hr>

                <!-- Zakres ceny -->
                <label class="form-label small fw-semibold">Cena zamówienia (zł)</label>
                <div class="d-flex gap-2 mb-3">
                    <input type="number" id="filterMin" class="form-control bg-light"
                           min="0" step="0.01" placeholder="Min">
                    <input type="number" id="filterMax" class="form-control bg-light"
                           min="0" step="0.01" placeholder="Max">
                </div>

                <hr>

                <!-- Statusy – value musi zgadzać się z data-status kart -->
                <h6 class="mb-3 fw-bold">Status</h6>

                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input status-filter"
                           id="filterPending" value="pending" checked>
                    <label class="form-check-label" for="filterPending">Oczekujące</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input status-filter"
                           id="filterReady" value="ready" checked>
                    <label class="form-check-label" for="filterReady">Gotowe</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input status-filter"
                           id="filterClaimed" value="claimed" checked>
                    <label class="form-check-label" for="filterClaimed">Odebrane</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input status-filter"
                           id="filterCanceled" value="canceled" checked>
                    <label class="form-check-label" for="filterCanceled">Anulowane</label>
                </div>

                <button id="resetFilters" class="btn btn-danger col-8 offset-2">
                    Reset
                </button>

            </div>
        </div>
    </div>
</section>

<!-- LISTA ZAMÓWIEŃ -->
<section class="container-fluid my-4 px-3">
    <h2 class="mb-3">Zamówienia</h2>
    <p id="noOrdersMsg" class="text-muted fst-italic" style="display:none">Brak wyników.</p>

    <div id="orderList" class="d-flex flex-column gap-3">
        <?php if (empty($orders)): ?>
            <p class="text-muted fst-italic">Brak zamówień w bazie danych.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <?php renderOrderCard($order, $statusLabels, $nextStep); ?>
            <?php endforeach; ?>
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
            <div class="modal-body">
                Oznaczyć zamówienie jako odebrane? Zostanie usunięte z bazy danych.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wróć</button>
                <button type="button" id="confirmModalBtn" class="btn btn-success">Tak, odebrane</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php include BACKEND_PATH . "config/config.js.php" ?>
<script src="<?= PUBLIC_URL ?>js/admin/orderFilter.js"></script>
<script src="<?= PUBLIC_URL ?>js/admin/orderFetch.js"></script>

</body>
</html>