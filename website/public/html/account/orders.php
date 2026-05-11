<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanówienia - Zegowska szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>
<body class="<?=$_SESSION["theme"]?>">
<?php
$site = "orders";
include PUBLIC_PATH . "html/shared/header.php";
?>
<main>

    <section class="p-3">
        <div class="row g-4">
            <?php
            $id = $_SESSION["id"];

            $orders = $connection->query
            ("
            SELECT *
            FROM orders
            WHERE user_id = $id;
            ");
            while ($order = $orders->fetch_assoc())
            {
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                <div 
                    class="h-100 d-flex flex-column border p-1"

                >
                    <div class="p-2 d-flex flex-column flex-grow-1">
                        <h4
                            class="fw-bold">
                            <?= $order["created_at"] ?>
                        </h4>
                        <h6>
                            <?= $order["status"] ?>
                        </h6>
                        <p>
                            <?= $order["total_price"] ?> zł
                        </p>
                        <button
                            class="btn cart-bt w-100 fw-semibold shadow-sm p-1 m-0 detailsBtn"
                            data-id="<?= $order['id'] ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#detailsModal"
                        >
                            Zobacz szczegóły
                        </button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</main>

    
    <?php include "popups.php"?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=PUBLIC_URL?>js/account/details.js"></script>
</body>
</html>