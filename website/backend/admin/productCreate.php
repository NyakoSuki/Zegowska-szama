<div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
            <div
                class="product border rounded shadow-sm bg-body h-100 d-flex flex-column overflow-hidden"

                data-id="<?=$productId?>"
                data-name="<?=$productName?>"
                data-price="<?=$productPrice?>"
                data-type="<?=$productType?>"
                data-stock="<?=$productStock?>"
                data-available="<?=$productIsAvailable?>"
                data-discount="<?=$discountProcent?>"
                data-action="<?=$action?>"
            >

                <div class="bg-light d-flex flex-column justify-content-center align-items-center p-3 border-bottom">
                    <img
                        <?=$img === "add" ? 'id="productImg"' : ""?>
                        src="<?=PUBLIC_URL . "img/products/" . $productImg?>"
                        alt="<?=$productName?>"
                        class="img-fluid product-img <?=($productType === 'drink') ? 'w-25' : 'w-75'?>"
                    >
                </div>

                <form
                    name=""
                    class="createForm d-flex h-100"
                    method=""
                    action=""
                >
                <div class="p-3 d-flex flex-column flex-grow-1 gap-3">

                    <div>
                        <label class="form-label fw-semibold small mb-1">
                            Zdjęcie
                        </label>

                        <input
                            <?=$img === "add" ? 'id="productImgInput"' : ""?>
                            type="text"
                            name="imgInp"
                            value="<?=$productImg?>"
                            class="form-control form-control-sm"
                        >
                    </div>

                    <div>
                        <label class="form-label fw-semibold small mb-1">
                            Nazwa
                        </label>

                        <input
                            type="text"
                            name="nameInp"
                            value="<?=$productName?>"
                            class="form-control"
                        >
                    </div>

                    <div>
                        <label class="form-label fw-semibold small mb-1">
                            Opis
                        </label>

                        <textarea
                            name="descriptionInp"
                            rows="3"
                            class="form-control"
                        ><?=$productDescription?></textarea>
                    </div>

                    <div class="row g-2">

                        <div class="col-6">
                            <label class="form-label fw-semibold small mb-1">
                                Cena
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="priceInp"
                                value="<?=$productPrice?>"
                                class="form-control"
                            >
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-semibold small mb-1">
                                Stan
                            </label>

                            <input
                                type="number"
                                name="stockInp"
                                value="<?=$productStock?>"
                                class="form-control"
                            >
                        </div>

                    </div>

                    <div>
                        <label class="form-label fw-semibold small mb-1">
                            Typ produktu
                        </label>

                        <select
                            class="form-select"
                            name="typeSel"
                        >
                            <option value="food" <?=$productType === 'food' ? 'selected' : ''?>>
                                Jedzenie
                            </option>

                            <option value="drink" <?=$productType === 'drink' ? 'selected' : ''?>>
                                Napój
                            </option>

                            <option value="school" <?=$productType === 'school' ? 'selected' : ''?>>
                                Szkoła
                            </option>
                        </select>
                    </div>

                    <div class="row g-2">

                        <div class="col-6">
                            <div class="form-check form-switch">

                                <input
                                    type="checkbox"
                                    name="availableInp"
                                    class="form-check-input"
                                    <?=$productIsAvailable ? 'checked' : ''?>
                                >

                                <label class="form-check-label">
                                    Dostępny
                                </label>

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-check form-switch">

                                <input
                                    type="checkbox"
                                    name="activeInp"
                                    class="form-check-input"
                                    <?=$productIsActive ? 'checked' : ''?>
                                >

                                <label class="form-check-label">
                                    Aktywny
                                </label>

                            </div>
                        </div>
                    </div>

                    <?php if($button === "add") { ?>

                        <button
                            type="submit"
                            name="actionBtn"
                            value="add"
                            class="btn btn-secondary fw-semibold mt-auto"
                        >
                            Dodaj produkt
                        </button>

                    <?php } else {?>
                    <div
                        class="d-flex mt-auto"
                    >
                        <input
                            name="idInp"
                            class=" col-3 border rounded-2"
                            value="<?=$productId?>"
                            type="number"
                            placeholder=""
                            readonly
                        >

                        <button
                            type="submit"
                            name="actionBtn"
                            value="update"
                            class="btn btn-dark fw-semibold col-8 ms-auto"
                        >
                            Zapisz zmiany
                        </button>
                    </div>
                    <?php } ?>

                </div>
                </form>

            </div>
        
</div>