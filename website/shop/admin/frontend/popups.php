<!-- USER -->
<div
    class="modal fade"
    id="userModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie Urzytkownikami</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                    <div class="card bg-light border-dark shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-3">
                                Filtry
                            </h6>
                            <input
                                type="text"
                                id="searchName"
                                class="form-control border-secondary mb-2"
                                placeholder="Szukaj po nazwie..."
                            >
                            <input
                                type="text"
                                id="searchEmail"
                                class="form-control border-secondary mb-2"
                                placeholder="Szukaj po emailu..."
                            >
                            <input
                                type="text"
                                id="searchRole"
                                class="form-control border-secondary mb-2"
                                placeholder="Szukaj po roli..."
                            >
                            <div class="row justify-content-center mb-4">
                                <button
                                    id="userActive"
                                    class="btn btn-secondary w-75 h-100 mb-2">
                                    Wyświetla wszytskich
                                </button>
                            </div>
                            <button
                                    id="resetBtn"
                                    class="btn btn-danger col-8 offset-2">
                                    Reset
                            </button>

                        </div>
                    </div>

                        <?php
                        $result = $connection->query("SELECT * FROM users");
                        ?>

                     <select id="userSelect">
                        <option>Wybierz Urzytkownika</option>
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

                     <form action="<?=ADMIN_B_URL?>update-users.php" method="post" id="userForm">

                        <label for="userChangeId">id:</label>
                        <input
                            id="userChangeId"
                            name="id"
                            type="text"
                            readonly
                        ><br>
                        <label for="userChangeName">Nazwa:</label>
                        <input
                            type="text"
                            id="userChangeName"
                            name="name"
                            placeholder="Nazwa"
                        ><br>
                        <label for="userChangeEmail">Email:</label>
                        <input
                            type="text"
                            id="userChangeEmail"
                            name="email"
                            placeholder="Email">
                        </input><br>
                        <label for="userChangeRole">Rola:</label>
                        <select id="userChangeRole">
                            <option value="none"></option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select><br>
                        <label for="userChangeActive">Aktywny:</label>
                        <input
                            type="checkbox"
                            id="userChangeActive"
                            name="active"
                        ><br>

                        <button type="submit">
                            Zapisz zmiany
                        </button>

                    </form>

            </div>

        </div>
    </div>
</div>





<!-- ORDER -->
<div
    class="modal fade"
    id="orderModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie Zamówieniami</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                
            </div>

        </div>
    </div>
</div>





<!-- PRODUCT -->
<div
    class="modal fade"
    id="productModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie Produktami</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                
            </div>

        </div>
    </div>
</div>





<!-- DISCOUNT -->
<div
    class="modal fade"
    id="discountModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie Promocjami</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                
            </div>

        </div>
    </div>
</div>




<?php
$result = $connection->query
("
    SELECT AUTO_INCREMENT 
    FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'products'
");

$row = $result->fetch_assoc();
$nextId = $row['AUTO_INCREMENT'];
?>

    <form action="<?=ADMIN_B_URL?>add-product.php" method="post" id="productForm">

        <label for="id">id:</label>
        <input
            id="id"
            name="id"
            type="text"
            value="<?=$nextId?>"
            readonly
        ><br>

        <input
            type="text"
            id="name"
            name="name"
            placeholder="Name"
        ><br>

        <textarea
            id="description"
            name="description"
            placeholder="Description">
        </textarea><br>

        <input
            type="number"
            id="price"
            name="price"
            step="0.01"
            placeholder="price"
        ><br>

        <input
            type="number"
            id="stock"
            name="stock"
            placeholder="stock"
        ><br>

        <input
            type="text"
            id="img"
            name="img"
            placeholder="img"
        ><br>

        <label for="is_available">Available:</label>
        <input
            type="checkbox"
            id="is_available"
            name="is_available"
        ><br>

        <button
            type="submit">
            add
        </button>

    </form>