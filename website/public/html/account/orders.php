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
$site = basename($_SERVER['PHP_SELF']); = "orders";
include PUBLIC_PATH . "html/shared/header.php";
?>
<main>

    <section class="p-3">
        <div class="row g-4">
            <?php
            $id = $_SESSION["id"];

            $connection->query
            ("
            SET lc_time_names = 'pl_PL';
            ");

            $orders = $connection->query
            ("
            SELECT *, DATE_FORMAT(created_at, '%e %M') AS date, DATE_FORMAT(created_at, '%k:%i') AS hour
            FROM orders
            WHERE user_id = $id
            ORDER BY created_at desc
            ");
            while ($order = $orders->fetch_assoc())
            {
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                <div class="product h-100 d-flex flex-column border p-1">

                    <div class="p-2 d-flex flex-column flex-grow-1">


                        <div class="d-flex align-items-center mb-2">

                            <h5 class="fw-bold p-0 m-0">
                                <?= $order["date"] ?>
                            </h5>

                            <span class="ms-auto small text-muted">
                                <?= $order["hour"] ?>
                            </span>
                        </div>


                        <p class="m-0 mb-2">
                            <span class="badge bg-secondary">
                                <?= htmlspecialchars($order["status"]) ?>
                            </span>
                        </p>


                        <div class="d-flex gap-2 align-items-end mb-3">

                            <p class="fw-bold m-0 h5">
                                <?= number_format($order["total_price"], 2) ?> zł
                            </p>

                        </div>


                        <button
                            class="btn w-100 fw-semibold shadow-sm p-1 m-0 btn-light border border-dark detailsBtn mt-auto"
                            data-id="<?= $order['id'] ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#detailsModal"
                        >
                            🔎 Szczegóły
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
    <?php include BACKEND_PATH . "config/config.js.php"?>
    <script src="<?=PUBLIC_URL?>js/account/details.js"></script>
</body>
</html>