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
                $productImg = '';

                $discountProcent = 0;

                $button = "add";
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

                $discountProcent = (int)$row["procent"];
                
                $button = "update";
                include BACKEND_PATH . 'admin/productCreate.php';

            endwhile;
            ?>

    </div>
</section>