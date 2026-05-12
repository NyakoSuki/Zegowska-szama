<!-- USER -->
<div
    class="modal fade"
    id="userModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie użytkownikami</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <!-- FILTRY -->
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Filtry</h6>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="userSearchName"
                                    class="form-control bg-white"
                                    placeholder="Nazwa..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="userSearchEmail"
                                    class="form-control bg-white"
                                    placeholder="Email..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="userSearchRole"
                                    class="form-control bg-white"
                                    placeholder="Rola..."
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button
                                id="userSearchActive"
                                class="btn btn-info">
                                Wyświetla wszystkich
                            </button>

                            <button
                                id="userResetBtn"
                                class="btn btn-danger">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                $result = $connection->query("SELECT * FROM users");
                ?>

                <!-- SELECT -->
                <div class="mb-4 bg-white">
                    <label class="form-label fw-semibold">Wybierz użytkownika</label>
                    <select id="userSelect" class="form-select bg-light">
                        <option>-- wybierz --</option>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <option
                            class="user"
                            value="<?= $row['id'] ?>"
                            data-id="<?=$row["id"] ?>"
                            data-username="<?=$row["username"] ?>"
                            data-email="<?=$row["email"] ?>"
                            data-role="<?=$row["role"] ?>"
                            data-active="<?=$row["is_active"] ?>"
                        >
                            <?= "Nazwa: " . $row["username"] . ", Email: " . $row["email"] ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- FORMULARZ -->
                <form action="<?=ADMIN_B_URL?>update-user.php" method="post" id="userForm">

                    <div class="row g-3">

                        <div class="col-md-2">
                            <label class="form-label">ID</label>
                            <input
                                id="userId"
                                name="id"
                                type="number"
                                class="form-control bg-light"
                                readonly
                            >
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Nazwa</label>
                            <input
                                type="text"
                                id="userName"
                                name="username"
                                class="form-control bg-light"
                                placeholder="Nazwa"
                            >
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Email</label>
                            <input
                                type="text"
                                id="userEmail"
                                name="email"
                                class="form-control bg-light"
                                placeholder="Email"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rola</label>
                            <select id="userRole" class="form-select bg-light" name="role">
                                <option value="">-- wybierz --</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="userActive"
                                    name="active"
                                    class="form-check-input"
                                >
                                <label class="form-check-label">
                                    Aktywny
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4">
                            Zapisz zmiany
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

