<!-- DISCOUNT -->
<div
    class="modal fade"
    id="discountModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
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

                <!-- FILTRY -->
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Filtry</h6>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="discountSearchName"
                                    class="form-control"
                                    placeholder="Nazwa..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    id="discountSearchMin"
                                    class="form-control"
                                    placeholder="Procent min..."
                                >
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    id="discountSearchMax"
                                    class="form-control"
                                    placeholder="Procent max..."
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button
                                id="discountSearchAvailable"
                                class="btn btn-info">
                                Wyświetla wszystkie
                            </button>

                            <button
                                id="discountResetBtn"
                                class="btn btn-danger">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                $result = $connection->query
                ("
                SELECT * FROM discounts
                JOIN products
                    ON discounts.product_id = products.id;
                ");
                ?>

                <!-- SELECT -->
                <div class="mb-4 row">
                    <label class="form-label fw-semibold">Wybierz produkt</label>
                    <div class="col-md-8 col-12">
                        <select id="discountSelect" class="form-select">
                            <option>-- wybierz --</option>

                            <?php while($row = $result->fetch_assoc()): ?>
                            <option
                                class="discountList"
                                value="<?= $row['id'] ?>"
                                data-id="<?=$row["id"] ?>"
                                data-productid="<?=$row["product_id"] ?>"
                                data-name="<?=$row["name"] ?>"
                                data-procent="<?=$row["procent"] ?>"
                                data-start="<?=$row["start_date"] ?>"
                                data-end="<?=$row["end_date"] ?>"
                            >
                                <?= "Nazwa produktu: " . $row["name"] . ", Procent: " . $row["procent"] ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                        <div class="col-md-4 col-12 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="discountAdd"
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
                    AND TABLE_NAME = 'discounts'
                ");

                $row = $result->fetch_assoc();
                $nextId = $row['AUTO_INCREMENT'];
                ?>

                <!-- FORMULARZ -->
                <form action="<?=ADMIN_B_URL?>update-discount.php" method="post" id="discountForm">

                    <div class="row g-3">

                        <div class="col-md-2">
                            <label class="form-label">ID</label>
                            <input
                                id="discountId"
                                name="id"
                                type="number"
                                class="form-control"
                                readonly
                            >
                            <input
                                id="discountIdNext"
                                name="idNext"
                                type="number"
                                class="form-control d-none"
                                value="<?=$nextId?>"
                                readonly
                            >
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Nazwa</label>
                            <input
                                type="text"
                                id="discountName"
                                name="name"
                                class="form-control"
                                placeholder="Nazwa"
                            >
                        </div>

                        <div class="col-md-5 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    id="discountAvailable"
                                    name="available"
                                    class="form-check-input"
                                >
                                <label class="form-check-label">
                                    Dostępny
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cena</label>
                            <input
                                type="number"
                                id="discountPrice"
                                name="price"
                                class="form-control"
                                step=0.01
                                placeholder="Cena"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ilość</label>
                            <input
                                type="number"
                                id="discountStock"
                                name="stock"
                                class="form-control"
                                placeholder="Ilość"
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label">Opis</label>
                            <textarea
                                id="discountDescription"
                                name="description"
                                class="form-control"
                                placeholder="Opis"
                            ></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Link do zdjęcia</label>
                            <textarea
                                id="discountImg"
                                name="img"
                                class="form-control"
                                placeholder="Link"
                            ></textarea>
                        </div>

                    </div>

                    <input type="hidden" id="addSwitchValue" name="addSwitchValue" value="update">

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4" id="discountSaveBtn">
                            Zapisz zmiany
                        </button>
                        <button type="submit" class="btn btn-success px-4 d-none" id="discountAddBtn">
                            Dodaj produkt
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<script src="<?=JS_URL?>admin-filter-discounts.js"></script>