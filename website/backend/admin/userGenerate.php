<?php
// userGenerate.php – funkcje generujące fragmenty HTML dla użytkowników


function renderUserCardHeader(array $user): void
{
    $id       = $user['id'];
    $username = htmlspecialchars($user['username']);
    $role     = htmlspecialchars($user['role']);
    $active   = (int)$user['is_active'];
    $roleLabel   = $role === 'admin' ? 'Admin' : 'Użytkownik';
    $activeLabel = $active ? 'Aktywny' : 'Nieaktywny';
    $activeBadge = $active ? 'active' : 'inactive';
    $date     = htmlspecialchars($user['created_at']);

    echo <<<HTML
    <div class="card-header d-flex align-items-center gap-2 flex-wrap">
        <strong>#$id</strong>
        <span class="fw-semibold">$username</span>
        <span class="badge badge-$role rounded-pill">$roleLabel</span>
        <span class="badge badge-$activeBadge rounded-pill">$activeLabel</span>
        <span class="ms-auto text-muted small">$date</span>
    </div>
    HTML;
}


function renderUserInfo(array $user): void
{
    $email          = htmlspecialchars($user['email']);
    $lastLogin      = $user['last_login']
        ? htmlspecialchars($user['last_login'])
        : '<span class="text-muted">—</span>';
    $failedClass    = $user['failed_attempts'] > 0 ? 'text-danger fw-bold' : '';
    $failedAttempts = (int)$user['failed_attempts'];

    echo <<<HTML
    <div class="col-12 col-md-5">
        <p class="mb-1"><strong>E-mail:</strong>
            <a href="mailto:$email">$email</a>
        </p>
        <p class="mb-1"><strong>Ostatnie logowanie:</strong> $lastLogin</p>
        <p class="mb-0"><strong>Nieudane próby logowania:</strong>
            <span class="$failedClass">$failedAttempts</span>
        </p>
    </div>
    HTML;
}


function renderUserActions(array $user, int $sessionId): void
{
    $id       = $user['id'];
    $active   = (int)$user['is_active'];
    $role     = $user['role'];
    $username = htmlspecialchars($user['username']);

    echo '<div class="col-12 col-md-7 d-flex flex-wrap gap-2 justify-content-md-end">';

    // toggle aktywności
    echo '<form class="user-action-form d-inline">';
    echo "<input type=\"hidden\" name=\"user_id\" value=\"$id\">";
    echo '<input type="hidden" name="action"  value="toggle_active">';
    if ($active) {
        echo <<<HTML
        <button type="button"
                class="btn btn-warning btn-sm needs-confirm"
                data-username="$username"
                data-action="deactivate">
            🚫 Dezaktywuj
        </button>
        HTML;
    } else {
        echo '<button type="submit" class="btn btn-success btn-sm">✅ Aktywuj</button>';
    }
    echo '</form>';

    // zmiana roli (tylko jeśli nie to samo konto)
    if ($id !== $sessionId) {
        echo '<form class="user-action-form d-inline">';
        echo "<input type=\"hidden\" name=\"user_id\" value=\"$id\">";
        echo '<input type="hidden" name="action"  value="set_role">';
        if ($role === 'user') {
            echo '<input type="hidden" name="role" value="admin">';
            echo <<<HTML
            <button type="button"
                    class="btn btn-outline-secondary btn-sm needs-confirm"
                    data-username="$username"
                    data-action="make_admin">
                👑 Zrób adminem
            </button>
            HTML;
        } else {
            echo '<input type="hidden" name="role" value="user">';
            echo <<<HTML
            <button type="button"
                    class="btn btn-outline-secondary btn-sm needs-confirm"
                    data-username="$username"
                    data-action="remove_admin">
                👤 Odbierz admina
            </button>
            HTML;
        }
        echo '</form>';
    }

    echo '</div>';
}


function renderUserCard(array $user): void
{
    $id     = $user['id'];
    $active = (int)$user['is_active'];
    $role   = htmlspecialchars($user['role']);
    $search = strtolower(htmlspecialchars($user['username'] . ' ' . $user['email'] . ' ' . $user['id']));

    // session_id() zwróciłoby ID sesji PHP, nie użytkownika – przekazujemy przez globalny
    $sessionUserId = (int)($_SESSION['id'] ?? 0);

    echo <<<HTML
    <div class="card user-card shadow-sm"
         data-active="$active"
         data-role="$role"
         data-search="$search">
    HTML;

    renderUserCardHeader($user);

    echo '<div class="card-body"><div class="row g-3 align-items-center">';
    renderUserInfo($user);
    renderUserActions($user, $sessionUserId);
    echo '</div></div></div>';
}