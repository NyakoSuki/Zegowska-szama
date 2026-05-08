<!-- PRODUCT -->
<div
    class="modal fade"
    id="productModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-white rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zarządzanie produktami</h5>
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
                                    id="productSearchName"
                                    class="form-control bg-white"
                                    placeholder="Szukaj po nazwie..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    id="productSearchMin"
                                    class="form-control bg-white"
                                    placeholder="Cena minimalna"
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    id="productSearchMax"
                                    class="form-control bg-white"
                                    placeholder="Cena maksymalna"
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button
                                id="productSearchAvailable"
                                class="btn btn-info">
                                Wyświetla wszystkie
                            </button>

                            <button
                                id="productResetBtn"
                                class="btn btn-danger">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                $result = $connection->query("SELECT * FROM products");
                ?>

                <!-- SELECT -->
                <div class="mb-4 row bg-whte">
                    <label class="form-label fw-semibold">Wybierz produkt</label>
                    <div class="col-md-8 col-12">
                        <select id="productSelect" class="form-select bg-light">
                            <option>-- wybierz --</option>

                            <?php while($row = $result->fetch_assoc()): ?>
                            <option
                                class="productList"
                                value="<?= $row['id'] ?>"
                                data-id="<?=$row["id"] ?>"
                                data-name="<?=$row["name"] ?>"
                                data-description="<?=$row["description"] ?>"
                                data-type="<?=$row["type"] ?>"
                                data-price="<?=$row["price"] ?>"
                                data-stock="<?=$row["stock"] ?>"
                                data-img="<?=$row["img"] ?>"
                                data-available="<?=$row["is_available"] ?>"
                                data-active="<?=$row["is_active"] ?>"
                            >
                                <?= "Nazwa: " . $row["name"] . ", Cena: " . $row["price"] ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                        <div class="col-md-4 col-12 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="productAdd"
                                    name="add"
                                    class="form-check-input"
                                >
                                <label class="form-check-label">
                                    Dodawanie
                                </label>
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

                <!-- FORMULARZ -->
                <form action="<?=ADMIN_B_URL?>update-product.php" method="post" id="productForm">

                    <div class="row g-3">
                        <div class="col-lg-6 row">
                            <div class="col-md-4">
                                <label class="form-label">ID</label>
                                <input
                                    id="productId"
                                    name="id"
                                    type="number"
                                    class="form-control bg-light"
                                    readonly
                                >
                                <input
                                    id="productIdNext"
                                    name="idNext"
                                    type="number"
                                    class="form-control bg-light d-none"
                                    value="<?=$nextId?>"
                                    readonly
                                >
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Nazwa</label>
                                <input
                                    type="text"
                                    id="productName"
                                    name="name"
                                    class="form-control bg-light"
                                    placeholder="Nazwa"
                                >
                            </div>
                        </div>
                        <div class="col-lg-6 row">
                            <div class="col-md-6">
                                <label class="form-label">Typ</label>
                                <select id="productType" class="form-select bg-light" name="type">
                                    <option value="">-- wybierz --</option>
                                    <option value="food">Jedzenie</option>
                                    <option value="drink">Napój</option>
                                    <option value="school">Szkoła</option>
                                </select>
                            </div>

                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input
                                        type="checkbox"
                                        id="productAvailable"
                                        name="available"
                                        class="form-check-input"
                                    >
                                    <label class="form-check-label">
                                        Dostępny
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cena</label>
                            <input
                                type="number"
                                id="productPrice"
                                name="price"
                                class="form-control bg-light"
                                step=0.01
                                placeholder="Cena"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ilość</label>
                            <input
                                type="number"
                                id="productStock"
                                name="stock"
                                class="form-control bg-light"
                                placeholder="-1 -> nieskończona"
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label">Opis</label>
                            <textarea
                                id="productDescription"
                                name="description"
                                class="form-control bg-light"
                                placeholder="Opis"
                            ></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Zdjęcie</label>
                            <textarea
                                id="productImg"
                                name="img"
                                class="form-control bg-light"
                                placeholder="np. bułka.png"
                            ></textarea>
                        </div>

                    </div>

                    <input type="hidden" id="addSwitchValue" name="addSwitchValue" value="update">

                    <div class="mt-4 d-flex text-start">

                        <div class="col-md-6 mb-2 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="productActive"
                                    name="active"
                                    class="form-check-input"
                                >
                                <label class="form-check-label">
                                    Aktywny
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success px-4 ms-auto" id="productSaveBtn">
                            Zapisz zmiany
                        </button>
                        <button type="submit" class="btn btn-success px-4 ms-auto d-none" id="productAddBtn">
                            Dodaj produkt
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

