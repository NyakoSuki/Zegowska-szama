<?php
session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

    if ($_SESSION["role"] !== "admin") 
    {
        //header("Location: " . ACCOUNT_F_URL . "account.php");
        //exit;
    }

// Fetch all products for checkboxes
$allProducts = [];
$prodQuery = $connection->query("SELECT id, name FROM products WHERE is_active = 1 ORDER BY name");
while ($p = $prodQuery->fetch_assoc()) {
    $allProducts[] = $p;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - Promocje</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    $site = basename($_SERVER['PHP_SELF']);
    $folder = basename(__DIR__);
    include PUBLIC_PATH . "html/shared/header.php";
    ?>

    <?php
    $query = $connection->query
    ("
        SELECT
            d.id,
            d.procent,
            d.start_date,
            d.end_date,
            CASE WHEN d.start_date <= NOW() AND d.end_date >= NOW() THEN 1 ELSE 0 END AS is_active_now,
            GROUP_CONCAT(dp.product_id ORDER BY dp.product_id SEPARATOR ',') AS product_ids
        FROM discounts d
        LEFT JOIN discounted_products dp ON d.id = dp.discount_id
        GROUP BY d.id
        ORDER BY d.end_date DESC
    ");
    ?>

    <section class="products p-3">
        <div class="row g-4">

        <?php
            $discountId          = 0;
            $discountProcent     = 0;
            $discountStart       = '';
            $discountEnd         = '';
            $discountProducts    = '';
            $discountIsActiveNow = 0;
            $action              = "add";
            $button              = "add";
            include BACKEND_PATH . 'admin/discountGenerate.php';
        ?>

        <?php while ($row = $query->fetch_assoc()):
            $discountId          = (int)$row["id"];
            $discountProcent     = (int)$row["procent"];
            $discountStart       = $row["start_date"];
            $discountEnd         = $row["end_date"];
            $discountIsActiveNow = (int)$row["is_active_now"];
            $discountProducts    = $row["product_ids"] ?? '';
            $action              = "update";
            $button              = "update";
            include BACKEND_PATH . 'admin/discountGenerate.php';
        endwhile;
        ?>

        </div>
    </section>

   <section>
    <div id="filters" class="filterDisabled col-12 col-sm-6 col-lg-4 col-xxl-4 h-75 overflow-auto">
        <div class="card bg-white">
            <div class="card-body">

                <h6 class="mb-3 fw-bold">Filtry promocji</h6>

                <!-- Zakres procentu -->
                <label class="form-label small fw-semibold">Procent zniżki (%)</label>
                <div class="d-flex gap-2 mb-3">
                    <input type="number" id="filterMin" class="form-control bg-light"
                           min="1" max="100" placeholder="Min %">
                    <input type="number" id="filterMax" class="form-control bg-light"
                           min="1" max="100" placeholder="Max %">
                </div>

                <hr>

                <h6 class="mb-3 fw-bold">Status</h6>

                <div class="form-check form-switch mb-2">
                    <input id="filterIsActive" type="checkbox" class="form-check-input" checked>
                    <label class="form-check-label">Aktywna teraz</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input id="filterIsAvailable" type="checkbox" class="form-check-input" checked>
                    <label class="form-check-label">Przyszła</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input id="filterIsUnavailable" type="checkbox" class="form-check-input" checked>
                    <label class="form-check-label">Wygasła</label>
                </div>

                <button id="resetFiltersBtn" class="btn btn-danger col-8 offset-2">
                    Reset
                </button>

            </div>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include BACKEND_PATH . "config/config.js.php"?>
    <?php include "popup.php"?>
    <script src="<?=PUBLIC_URL?>js/admin/discountFetch.js"></script>
    <script src="<?=PUBLIC_URL?>js/admin/discountFilter.js"></script>
</body>
</html>