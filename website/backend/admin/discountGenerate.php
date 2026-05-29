<?php
// Build array of currently selected product IDs for this discount
$selectedIds = array_filter(array_map('intval', explode(",", $discountProducts)));
?>

<div class="col-12 col-sm-6 col-lg-4 col-xxl-4">

    <!-- Discount card -->
    <div
        class="product border rounded shadow-sm bg-body h-100 d-flex flex-column overflow-hidden"
        data-id="<?=$discountId?>"
        data-procent="<?=$discountProcent?>"
        data-start="<?=$discountStart?>"
        data-end="<?=$discountEnd?>"
        data-active="<?=$discountIsActiveNow?>"
        data-action="<?=$action?>"
    >

        <!-- Status banner -->
        <?php if ($button !== "add"): ?>
        <div class="px-3 pt-3">
            <?php
                $now = new DateTime();
                if ($discountIsActiveNow): ?>
                    <span class="badge bg-success w-100 py-2 fs-6">✔ Aktywna teraz</span>
                <?php else:
                    $end = new DateTime($discountEnd);
                    if ($now > $end): ?>
                        <span class="badge bg-secondary w-100 py-2 fs-6">✖ Wygasła</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark w-100 py-2 fs-6">⏳ Przyszła</span>
                    <?php endif;
                endif;
            ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="createDiscountForm d-flex h-100" method="" action="">

            <div class="p-3 d-flex flex-column flex-grow-1 gap-3">

                <!-- Percent -->
                <div>
                    <label class="form-label fw-semibold small mb-1">Procent zniżki (%)</label>
                    <div class="input-group">
                        <input
                            type="number"
                            name="procentInp"
                            min="1"
                            max="100"
                            value="<?=$discountProcent?>"
                            class="form-control"
                            placeholder="np. 20"
                        >
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <!-- Dates -->
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold small mb-1">Data od</label>
                        <input
                            type="datetime-local"
                            name="startInp"
                            value="<?=str_replace(' ', 'T', substr($discountStart, 0, 16))?>"
                            class="form-control"
                        >
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small mb-1">Data do</label>
                        <input
                            type="datetime-local"
                            name="endInp"
                            value="<?=str_replace(' ', 'T', substr($discountEnd, 0, 16))?>"
                            class="form-control"
                        >
                    </div>
                </div>

                <!-- Products checkboxes -->
                <div>
                    <label class="form-label fw-semibold small mb-1">Produkty objęte promocją</label>
                    <div class="border rounded p-2 bg-light" style="max-height: 180px; overflow-y: auto;">
                        <?php if (empty($allProducts)): ?>
                            <small class="text-muted">Brak aktywnych produktów</small>
                        <?php else: ?>
                            <?php foreach ($allProducts as $prod):
                                $checked = in_array((int)$prod['id'], $selectedIds) ? 'checked' : '';
                            ?>
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="productsInp[]"
                                    value="<?=(int)$prod['id']?>"
                                    class="form-check-input"
                                    <?=$checked?>
                                >
                                <label class="form-check-label">
                                    <?=htmlspecialchars($prod['name'])?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Buttons -->
                <?php if ($button === "add"): ?>

                <div class="mt-auto d-flex">
                    <button type="submit" name="actionBtn" value="add" class="btn btn-dark fw-semibold col-6">
                        Dodaj promocję
                    </button>
                    <button type="reset" class="btn btn-danger fw-semibold ms-1 col-6">
                        Wyczyść
                    </button>
                </div>

                <?php else: ?>

                <div class="d-flex mt-auto align-items-center gap-1">
                    <label class="form-check-label text-muted small me-1">ID</label>
                    <input
                        name="idInp"
                        class="border rounded-2 p-2 text-center"
                        style="width: 50px;"
                        value="<?=$discountId?>"
                        type="number"
                        readonly
                    >
                    <button type="submit" name="actionBtn" value="update" class="btn btn-dark fw-semibold flex-grow-1">
                        Zapisz zmiany
                    </button>
                    <button type="submit" name="actionBtn" value="delete" class="btn btn-danger fw-semibold">
                        Usuń
                    </button>
                </div>

                <?php endif; ?>

            </div>
        </form>

    </div>

</div>