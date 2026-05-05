<!-- USER -->
<div
    class="modal fade"
    id="userModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow">

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
                                    id="searchName"
                                    class="form-control"
                                    placeholder="Nazwa..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="searchEmail"
                                    class="form-control"
                                    placeholder="Email..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="searchRole"
                                    class="form-control"
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
                                id="resetBtn"
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
                <div class="mb-4">
                    <label class="form-label fw-semibold">Wybierz użytkownika</label>
                    <select id="userSelect" class="form-select">
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
                                class="form-control"
                                readonly
                            >
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Nazwa</label>
                            <input
                                type="text"
                                id="userName"
                                name="username"
                                class="form-control"
                                placeholder="Nazwa"
                            >
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Email</label>
                            <input
                                type="text"
                                id="userEmail"
                                name="email"
                                class="form-control"
                                placeholder="Email"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rola</label>
                            <select id="userRole" class="form-select" name="role">
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

<script src="<?=JS_URL?>admin-filter-users.js"></script>