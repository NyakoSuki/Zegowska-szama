<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

    if ($_SESSION["role"] !== "admin") 
    {
        //header("Location: " . ACCOUNT_F_URL . "account.php");
        //exit;
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    //---HEADER---
    $site = basename($_SERVER['PHP_SELF']);
    $folder = basename(__DIR__);
    include PUBLIC_PATH . "html/shared/header.php";
    ?>

        <?php
        $query = $connection->query
        ("
        SELECT
            p.id,
            p.name,
            p.description,
            p.type,
            p.price,
            p.stock,
            p.is_available,
            p.is_active,
            p.img,
            d.procent,
            d.start_date,
            d.end_date
        FROM products p
        LEFT JOIN
        (
            SELECT *
            FROM
            (
                SELECT 
                    d.*,
                    dp.product_id,
                    ROW_NUMBER() OVER
                    (
                        PARTITION BY dp.product_id
                        ORDER BY d.procent DESC
                    ) AS rn
                FROM discounts d
                JOIN discounted_products dp 
                    ON d.id = dp.discount_id
                WHERE d.start_date <= NOW()
                AND d.end_date >= NOW()
            ) x
            WHERE rn = 1
        ) d ON p.id = d.product_id
        ORDER BY p.type;
        ");
        ?>
        <section
            class="products p-3"
        >
            <div
                class="row g-4"
            >

            <?php
                $productId = 0;
                $productName = '';
                $productDescription = '';
                $productType = 'food';
                $productPrice = 0;
                $productStock = 0;
                $productIsAvailable = 1;
                $productIsActive = 1;
                $productImg = isset($_POST["imgAdd"]) ? $_POST["imgAdd"] : '';
                $action = "add";

                $discountProcent = 0;

                $button = "add";
                $img = "add";
                include BACKEND_PATH . 'admin/productCreate.php';
            ?>

            <?php while ($row = $query->fetch_assoc()):
                $productId = (int)$row["id"];
                $productName = $row["name"];
                $productDescription = $row["description"];
                $productType = $row["type"];
                $productPrice = (float)$row["price"];
                $productStock = (int)$row["stock"];
                $productIsAvailable = (int)$row["is_available"];
                $productIsActive = (int)$row["is_active"];
                $productImg = $row["img"];
                $action = "update";

                $discountProcent = (int)$row["procent"];
                
                $button = "update";
                $img = "update";
                include BACKEND_PATH . 'admin/productCreate.php';

            endwhile;
            ?>

    </div>
</section>
<section>
            <div
                id="filters"
                class="filterDisabled
                col-12 col-sm-6 col-md-4 col-lg-6 col-xxl-4 mt-2"
            >
                <div
                    class="card bg-white"
                >
                    <div
                        class="card-body"
                    >
                        <h6
                            class="mb-3 fw-bold"
                        >
                            Filtry
                        </h6>
                        <input
                            type="text"
                            id="filterName"
                            class="form-control bg-light mb-2"
                            placeholder="Szukaj po nazwie..."
                        >
                        <input
                            type="number"
                            id="filterMin"
                            class="form-control bg-light mb-2"
                            step=0.01
                            placeholder="Cena minimalna"
                        >
                        <input
                            type="number"
                            id="filterMax"
                            class="form-control bg-light mb-3"
                            step=0.01
                            placeholder="Cena maksymalna"
                        >
                        <hr>
                        <h6
                            class="mb-3 fw-bold"
                        >
                            Zaznacz kategorie
                        </h6>

                        <div
                            class="row justify-content-center mb-1 gap-4"
                        >
                            <button
                                id="filterIsAvailable"
                                class="btn btn-info opacity-50 col-5 h-100 mb-2"
                            >
                                Dostępne
                            </button>
                            <button 
                                id="filterIsDiscounted"
                                class="btn btn-info opacity-50 col-5 h-100"
                            >
                                Promocje
                            </button>
                        </div>
                        <div
                            class="row justify-content-center mb-4 gap-lg-4"
                        >
                            <button
                                id="filterFood"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Jedzenie
                            </button>
                            <button
                                id="filterDrink"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Napoje
                            </button>
                            <button
                                id="filterSchool"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Szkoła
                            </button>
                        </div>

                        <button
                                id="resetFiltersBtn"
                                class="btn btn-danger col-8 offset-2"
                            >
                                Reset
                        </button>

                    </div>
                </div>
            </div>
        </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include BACKEND_PATH . "config/config.js.php"?>
    <script src="<?=PUBLIC_URL?>js/admin/productFetch.js"></script>
    <script src="<?=PUBLIC_URL?>js/admin/productFilter.js"></script>
</body>
</html>