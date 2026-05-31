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
        data-start="<?=str_replace(' ', 'T', $discountStart)?>"
        data-end="<?=str_replace(' ', 'T', $discountEnd)?>"
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

        <?php if ($button === "add"): ?>

        <!-- Form – tylko dla tworzenia -->
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
                            value=""
                            class="form-control"
                        >
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small mb-1">Data do</label>
                        <input
                            type="datetime-local"
                            name="endInp"
                            value=""
                            class="form-control"
                        >
                    </div>
                </div>

                <!-- Products select -->
                <div>
                    <label class="form-label fw-semibold small mb-1">Produkty objęte promocją</label>
                    <?php if (empty($allProducts)): ?>
                        <p class="text-muted small">Brak aktywnych produktów</p>
                    <?php else: ?>
                        <select
                            name="productsInp[]"
                            multiple
                            class="form-select"
                            style="min-height: 150px;"
                        >
                            <?php foreach ($allProducts as $prod): ?>
                                <option value="<?=(int)$prod['id']?>">
                                    <?=htmlspecialchars($prod['name'])?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Ctrl+klik aby wybrać kilka</small>
                    <?php endif; ?>
                </div>

                <div class="mt-auto d-flex">
                    <button type="submit" name="actionBtn" value="add" class="btn btn-dark fw-semibold col-6">
                        Dodaj promocję
                    </button>
                    <button type="reset" class="btn btn-danger fw-semibold ms-1 col-6">
                        Wyczyść
                    </button>
                </div>

            </div>
        </form>

        <?php else: ?>

        <!-- Podgląd – tylko dla istniejących promocji -->
        <div class="p-3 d-flex flex-column flex-grow-1">

            <!-- Duży procent na górze -->
            <div class="text-center py-4 mb-3 rounded-3" style="background: rgba(0,0,0,.04);">
                <span class="text-muted small d-block mb-1 text-uppercase ls-1" style="font-size: .7rem; letter-spacing: .08em;">Zniżka</span>
                <span class="fw-bold lh-1" style="font-size: 3.5rem;"><?=$discountProcent?><span style="font-size: 1.8rem;">%</span></span>
            </div>

            <!-- Daty: dwie kafelki obok siebie -->
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="rounded-3 p-3 h-100" style="background: rgba(0,0,0,.04);">
                        <p class="text-muted mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: .08em;">Od</p>
                        <?php
                            $startFormatted = date('d.m.Y', strtotime($discountStart));
                            $startTime      = date('H:i',   strtotime($discountStart));
                        ?>
                        <p class="fw-semibold mb-0 lh-sm"><?=$startFormatted?></p>
                        <p class="text-muted mb-0 small"><?=$startTime?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded-3 p-3 h-100" style="background: rgba(0,0,0,.04);">
                        <p class="text-muted mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: .08em;">Do</p>
                        <?php
                            $endFormatted = date('d.m.Y', strtotime($discountEnd));
                            $endTime      = date('H:i',   strtotime($discountEnd));
                        ?>
                        <p class="fw-semibold mb-0 lh-sm"><?=$endFormatted?></p>
                        <p class="text-muted mb-0 small"><?=$endTime?></p>
                    </div>
                </div>
            </div>

            <!-- Lista produktów – rośnie i wypełnia wolne miejsce -->
            <?php
            $assignedNames = array_values(array_filter(
                array_map(fn($p) => in_array((int)$p['id'], $selectedIds)
                    ? htmlspecialchars($p['name'])
                    : null,
                $allProducts)
            ));
            ?>
            <div class="flex-grow-1 rounded-3 p-3 mb-3 overflow-auto" style="background: rgba(0,0,0,.04); min-height: 80px;">
                <p class="text-muted mb-2" style="font-size: .7rem; text-transform: uppercase; letter-spacing: .08em;">Produkty objęte promocją</p>
                <?php if (empty($assignedNames)): ?>
                    <p class="text-muted small mb-0 fst-italic">Brak przypisanych produktów</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-1">
                        <?php foreach ($assignedNames as $n): ?>
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-circle bg-secondary flex-shrink-0" style="width:6px;height:6px;"></span>
                                <span class="small"><?=$n?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Stopka: ID + przycisk Usuń -->
            <form class="createDiscountForm" method="" action="">
                <input type="hidden" name="idInp"      value="<?=$discountId?>">
                <input type="hidden" name="procentInp" value="<?=$discountProcent?>">
                <input type="hidden" name="startInp"   value="<?=str_replace(' ', 'T', substr($discountStart, 0, 16))?>">
                <input type="hidden" name="endInp"     value="<?=str_replace(' ', 'T', substr($discountEnd, 0, 16))?>">
                <div class="d-flex align-items-center">
                    <span class="text-muted small">ID&nbsp;<strong>#<?=$discountId?></strong></span>
                    <button type="submit" name="actionBtn" value="delete" class="btn btn-danger btn-sm fw-semibold ms-auto">
                        Usuń promocję
                    </button>
                </div>
            </form>

        </div>

        <?php endif; ?>

    </div>

</div>