<?php
session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

require_once BACKEND_PATH . "admin/userGenerate.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: " . ACCOUNT_F_URL . "account.php");
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

<section
    id="filters"
    class="filterDisabled col-12 col-sm-6 col-lg-4 col-xxl-4 h-75 overflow-auto"
>
    <div class="card bg-white">
        <div class="card-body">

            <h6 class="mb-3 fw-bold">Filtry</h6>

            <input
                type="text"
                id="searchInput"
                class="form-control bg-light mb-3"
                placeholder="Szukaj: nazwa, e-mail, ID…"
            >

            <hr>
            <h6 class="mb-3 fw-bold">Rola</h6>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="f_admin" checked>
                <label class="form-check-label" for="f_admin">Admin</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="f_user" checked>
                <label class="form-check-label" for="f_user">Użytkownik</label>
            </div>

            <hr>
            <h6 class="mb-3 fw-bold">Status</h6>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="f_active" checked>
                <label class="form-check-label" for="f_active">Aktywny</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="f_inactive" checked>
                <label class="form-check-label" for="f_inactive">Nieaktywny</label>
            </div>

            <button id="resetFilters" class="btn btn-danger col-8 offset-2">Reset</button>

        </div>
    </div>
</section>

<!-- LISTA UŻYTKOWNIKÓW -->
<section class="container-fluid my-4 px-3">
    <h2 class="mb-3">
        Użytkownicy <span class="text-muted fs-6">(<?= count($users) ?>)</span>
    </h2>
    <p id="noUsersMsg" class="text-muted fst-italic" style="display:none">Brak wyników.</p>

    <div id="userList" class="d-flex flex-column gap-3">
        <?php if (empty($users)): ?>
            <p class="text-muted fst-italic">Brak użytkowników w bazie danych.</p>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <?php renderUserCard($user); ?>
            <?php endforeach; ?>
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
<script src="<?= PUBLIC_URL ?>js/admin/userFilter.js"></script>
<script src="<?= PUBLIC_URL ?>js/admin/userFetch.js"></script>
</body>
</html>