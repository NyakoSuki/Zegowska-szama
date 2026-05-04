<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
?>

<!-- USERNAME CHAHGE -->
<div class="modal fade" id="usernameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">

                <h5 class="modal-title">Zmiana nazwy użytkownika</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form
                    action="<?=ACCOUNT_B_URL?>change-username.php"
                    method="post"
                    class="d-grid gap-2"
                >
                    <input
                        type="text"
                        name="username"
                        class="form-control bg-light mb-1"
                        placeholder="Nowa nazwa"
                    >
                    <button class="btn btn-dark">
                        Zmień nazwę
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>


<!-- PASSWORD CHAHGE -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">

                <h5 class="modal-title">Zmiana hasła</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form
                    action="<?=ACCOUNT_B_URL?>change-password.php"
                    method="post"
                    class="d-grid gap-2"
                >
                    <input
                        type="password"
                        name="current"
                        class="form-control bg-light"
                        placeholder="Obecne hasło"
                    >
                    <input
                        type="password" 
                        name="new"
                        class="form-control bg-light"
                        placeholder="Nowe hasło"
                    >
                    <input
                        type="password"
                        name="confirm"
                        class="form-control bg-light"
                        placeholder="Powtórz nowe hasło"
                    >
                    <button
                        class="btn btn-dark">
                        Zmień hasło
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>


<!-- LOGOUT -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Czy napewno chcesz się wylogować?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form
                    action="<?=ACCOUNT_B_URL?>logout.php"
                    method="post"
                    class="w-100 h-75 d-flex gap-2"
                >
                    <button 
                        class="btn btn-danger w-50">
                        Wyloguj się
                    </button>
                    <button
                        type="button"
                        class="btn btn-success w-50"
                        data-bs-dismiss="modal">
                        Anuluj
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>





<!-- ORDER DETAILS -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <input type="hidden" id="orderIdInput">
            <div class="modal-body" id="modal-body">

                

            </div>

        </div>
    </div>
</div>