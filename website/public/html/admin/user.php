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
    $id     = (int)($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($id > 0) {
        if ($action === 'toggle_active') {
            $stmt = $connection->prepare("UPDATE users SET is_active = NOT is_active WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } elseif ($action === 'set_role' && in_array($_POST['role'] ?? '', ['admin', 'user'])) {
            $role = $_POST['role'];
            $stmt = $connection->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->bind_param("si", $role, $id);
            $stmt->execute();
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- pobierz użytkowników ---
$result = $connection->query("
    SELECT id, username, email, role, is_active, created_at, last_login, failed_attempts
    FROM users
    ORDER BY created_at DESC
");

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Użytkownicy – Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= PUBLIC_URL ?>css/main.css">
    <style>
        #filterBar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--bs-body-bg, #fff);
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 6px rgba(0,0,0,.06);
        }
        .user-card[data-active="1"] { border-left: 4px solid #198754; }
        .user-card[data-active="0"] { border-left: 4px solid #dc3545; }
        .badge-active   { background: #198754; color: #fff; }
        .badge-inactive { background: #dc3545; color: #fff; }
        .badge-admin    { background: #6f42c1; color: #fff; }
        .badge-user     { background: #0d6efd; color: #fff; }
    </style>
</head>
<body class="<?= $_SESSION['theme'] ?>">

<?php
$site   = basename($_SERVER['PHP_SELF']);
$folder = basename(__DIR__);
include PUBLIC_PATH . "html/shared/header.php";
?>

<!-- FILTRY -->
<div id="filterBar" class="p-2">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <input type="text" id="searchInput" class="form-control" placeholder="Szukaj: nazwa, e-mail, ID…">
            </div>
            <div class="col-12 col-md-4 d-flex flex-wrap gap-3">
                <div class="form-check">
                    <input class="form-check-input role-filter" type="checkbox" id="f_admin" value="admin" checked>
                    <label class="form-check-label" for="f_admin">Admin</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input role-filter" type="checkbox" id="f_user" value="user" checked>
                    <label class="form-check-label" for="f_user">Użytkownik</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input active-filter" type="checkbox" id="f_active" value="1" checked>
                    <label class="form-check-label" for="f_active">Aktywny</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input active-filter" type="checkbox" id="f_inactive" value="0" checked>
                    <label class="form-check-label" for="f_inactive">Nieaktywny</label>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2 ms-md-auto">
                <button id="resetFilters" class="btn btn-danger w-100">Reset</button>
            </div>
        </div>
    </div>
</div>

<!-- LISTA UŻYTKOWNIKÓW -->
<section class="container-fluid my-4 px-3">
    <h2 class="mb-3">Użytkownicy <span class="text-muted fs-6">(<?= count($users) ?>)</span></h2>
    <p id="noUsersMsg" class="text-muted fst-italic" style="display:none">Brak wyników.</p>

    <div id="userList" class="d-flex flex-column gap-3">
    <?php foreach ($users as $u):
        $active = (int)$u['is_active'];
    ?>
        <div class="card user-card shadow-sm"
             data-active="<?= $active ?>"
             data-role="<?= htmlspecialchars($u['role']) ?>"
             data-search="<?= strtolower(htmlspecialchars($u['username'] . ' ' . $u['email'] . ' ' . $u['id'])) ?>">

            <div class="card-header d-flex align-items-center gap-2 flex-wrap">
                <strong>#<?= $u['id'] ?></strong>
                <span class="fw-semibold"><?= htmlspecialchars($u['username']) ?></span>
                <span class="badge badge-<?= $u['role'] ?> rounded-pill"><?= $u['role'] === 'admin' ? 'Admin' : 'Użytkownik' ?></span>
                <span class="badge badge-<?= $active ? 'active' : 'inactive' ?> rounded-pill">
                    <?= $active ? 'Aktywny' : 'Nieaktywny' ?>
                </span>
                <span class="ms-auto text-muted small"><?= $u['created_at'] ?></span>
            </div>

            <div class="card-body">
                <div class="row g-3 align-items-center">

                    <!-- info -->
                    <div class="col-12 col-md-5">
                        <p class="mb-1"><strong>E-mail:</strong>
                            <a href="mailto:<?= htmlspecialchars($u['email']) ?>"><?= htmlspecialchars($u['email']) ?></a>
                        </p>
                        <p class="mb-1"><strong>Ostatnie logowanie:</strong>
                            <?= $u['last_login'] ? htmlspecialchars($u['last_login']) : '<span class="text-muted">—</span>' ?>
                        </p>
                        <p class="mb-0"><strong>Nieudane próby logowania:</strong>
                            <span class="<?= $u['failed_attempts'] > 0 ? 'text-danger fw-bold' : '' ?>">
                                <?= (int)$u['failed_attempts'] ?>
                            </span>
                        </p>
                    </div>

                    <!-- akcje -->
                    <div class="col-12 col-md-7 d-flex flex-wrap gap-2 justify-content-md-end">

                        <!-- toggle aktywności -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="action"  value="toggle_active">
                            <?php if ($active): ?>
                                <button type="button"
                                        class="btn btn-warning btn-sm needs-confirm"
                                        data-username="<?= htmlspecialchars($u['username']) ?>"
                                        data-action="deactivate">
                                    🚫 Dezaktywuj
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success btn-sm">
                                    ✅ Aktywuj
                                </button>
                            <?php endif; ?>
                        </form>

                        <!-- zmiana roli (tylko jeśli nie to samo konto admina) -->
                        <?php if ($u['id'] !== (int)$_SESSION['id']): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="action"  value="set_role">
                            <?php if ($u['role'] === 'user'): ?>
                                <input type="hidden" name="role" value="admin">
                                <button type="button"
                                        class="btn btn-purple btn-sm btn-outline-secondary needs-confirm"
                                        data-username="<?= htmlspecialchars($u['username']) ?>"
                                        data-action="make_admin">
                                    👑 Zrób adminem
                                </button>
                            <?php else: ?>
                                <input type="hidden" name="role" value="user">
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm needs-confirm"
                                        data-username="<?= htmlspecialchars($u['username']) ?>"
                                        data-action="remove_admin">
                                    👤 Odbierz admina
                                </button>
                            <?php endif; ?>
                        </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($users)): ?>
        <p class="text-muted fst-italic">Brak użytkowników w bazie danych.</p>
    <?php endif; ?>
    </div>
</section>

<!-- Modal potwierdzenia -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalTitle">Potwierdzenie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1"></button>
            </div>
            <div class="modal-body" id="confirmModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="button" id="confirmModalBtn" class="btn btn-danger">Potwierdź</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php include BACKEND_PATH . "config/config.js.php" ?>
<script>
// filtry
const cards   = document.querySelectorAll('.user-card');
const noMsg   = document.getElementById('noUsersMsg');

function applyFilters() {
    const text          = document.getElementById('searchInput').value.toLowerCase().trim();
    const activeRoles   = [...document.querySelectorAll('.role-filter')].filter(c => c.checked).map(c => c.value);
    const activeStates  = [...document.querySelectorAll('.active-filter')].filter(c => c.checked).map(c => c.value);

    let visible = 0;
    cards.forEach(card => {
        const show = activeRoles.includes(card.dataset.role)
            && activeStates.includes(card.dataset.active)
            && (!text || card.dataset.search.includes(text));
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    noMsg.style.display = visible === 0 ? 'block' : 'none';
}

document.getElementById('searchInput').addEventListener('input', applyFilters);
document.querySelectorAll('.role-filter, .active-filter').forEach(cb => cb.addEventListener('change', applyFilters));
document.getElementById('resetFilters').addEventListener('click', () => {
    document.getElementById('searchInput').value = '';
    document.querySelectorAll('.role-filter, .active-filter').forEach(cb => cb.checked = true);
    applyFilters();
});

// modal potwierdzenia
const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
const confirmBtn   = document.getElementById('confirmModalBtn');
const modalTitle   = document.getElementById('confirmModalTitle');
const modalBody    = document.getElementById('confirmModalBody');
let pendingForm    = null;

const messages = {
    deactivate:   { title: 'Dezaktywuj konto',   body: (u) => `Czy na pewno chcesz dezaktywować konto użytkownika <strong>${u}</strong>? Nie będzie mógł się zalogować.`, btn: 'btn-warning' },
    make_admin:   { title: 'Nadaj uprawnienia',  body: (u) => `Czy na pewno chcesz nadać użytkownikowi <strong>${u}</strong> uprawnienia admina?`, btn: 'btn-danger' },
    remove_admin: { title: 'Odbierz uprawnienia',body: (u) => `Czy na pewno chcesz odebrać uprawnienia admina użytkownikowi <strong>${u}</strong>?`, btn: 'btn-danger' },
};

document.querySelectorAll('.needs-confirm').forEach(btn => {
    btn.addEventListener('click', () => {
        const action   = btn.dataset.action;
        const username = btn.dataset.username;
        const cfg      = messages[action];

        modalTitle.textContent  = cfg.title;
        modalBody.innerHTML     = cfg.body(username);
        confirmBtn.className    = `btn ${cfg.btn}`;
        confirmBtn.textContent  = 'Potwierdź';
        pendingForm             = btn.closest('form');

        confirmModal.show();
    });
});

confirmBtn.addEventListener('click', () => {
    if (pendingForm) pendingForm.submit();
});
</script>
</body>
</html>