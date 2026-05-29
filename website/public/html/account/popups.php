<!-- USERNAME CHAHGE -->
<div
    class="modal fade"
    id="usernameModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">

                <h5 class="modal-title">Zmiana nazwy użytkownika</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form
                    action="<?=BACKEND_URL?>account/usernameUpdate.php"
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
<div
    class="modal fade"
    id="passwordModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">

                <h5 class="modal-title">Zmiana hasła</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form
                    action="<?=BACKEND_URL?>account/passwordUpdate.php"
                    method="post"
                    class="d-grid gap-2"
                >
                    <div class="input-group mb-2">
                        <input
                            id="currentPasswordInp"
                            type="password"
                            name="current"
                            class="form-control bg-light"
                            placeholder="Obecne hasło"
                        >
                        <button
                            id="currentPasswordBtn"
                            class="btn btn-light"
                            type="button"
                        >
                        Pokaż
                        </button>
                    </div>
                    <div class="input-group mb-2">
                        <input
                            id="newPasswordInp"
                            type="password" 
                            name="new"
                            class="form-control bg-light"
                            placeholder="Nowe hasło"
                        >
                        <button
                            id="newPasswordBtn"
                            class="btn btn-light"
                            type="button"
                        >
                        Pokaż
                        </button>
                    </div>
                    <div class="input-group mb-2">
                        <input
                            id="confirmPasswordInp"
                            type="password"
                            name="confirm"
                            class="form-control bg-light"
                            placeholder="Powtórz nowe hasło"
                        >
                        <button
                            id="confirmPasswordBtn"
                            class="btn btn-light"
                            type="button"
                        >
                        Pokaż
                        </button>
                    </div>

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
<div
    class="modal fade"
    id="logoutModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Czy napewno chcesz się wylogować?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form
                    action="<?=BACKEND_URL?>account/logout.php"
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
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1"></button>
            </div>

            <div class="modal-body">
            </div>

        </div>
    </div>
</div>
