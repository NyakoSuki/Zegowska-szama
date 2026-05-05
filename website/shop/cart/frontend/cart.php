<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
include BASE_PATH . "config.js.php";

$cart = $_SESSION["cart"] ?? [];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - Zegowska Szama</title>
</head>

<body class="<?=$_SESSION['theme']?>">
    <?php
    //---HEADER---
    $_SESSION["site"] = "cart";
    include HEADER_PATH;
    ?>
    <main>
        <section class="d-flex flex-column flex-sm-row gap-2 mb-3 col-12 col-lg-6 offset-lg-3 p-3">

            <!-- ZAMÓWIENIE -->
            <button type="button" class="btn btn-success flex-fill col-lg-3 col-md-6 col-12 m-1" data-bs-toggle="modal" data-bs-target="#orderModal">
                Zamów
            </button>

            <!-- CZYSZCZENIE -->
            <button type="button" class="btn btn-danger flex-fill col-lg-3 col-md-6 col-12 m-1" data-bs-toggle="modal" data-bs-target="#clearModal">
                Wyczyść koszyk
            </button>

        </section>

        <section class="p-3">
            <div class="row g-4">
                <?php
                $products = $connection->query
                ("
                SELECT
                    p.id,
                    p.name,
                    p.description,
                    p.price,
                    p.stock,
                    p.is_available,
                    p.img,
                    d.procent,
                    d.start_date,
                    d.end_date
                FROM products p
                LEFT JOIN (
                    SELECT *
                    FROM (
                        SELECT 
                            d.*,
                            dp.product_id,
                            ROW_NUMBER() OVER (
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
                ORDER BY p.id;
                ");

                $totalPrice = 0;

                while ($product = $products->fetch_assoc()) 
                {
                    $id = $product["id"];

                    if (!isset($cart[$id])) continue;
                    if (!$product["is_available"]) continue;

                    $noDiscount = $product["procent"] === null;
                    $price = floor($product["price"] * (1 - ($product["procent"] ?? 0) / 100) * 100) / 100;
                    $qty = $cart[$id];
                    $totalPrice += $price * $qty;
                ?>

                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                    <div 
                        class="h-100 d-flex flex-column border p-1 product
                        <?= $noDiscount ? 'border-dark' : 'border-3 border-warning' ?> "

                        data-name="<?= strtolower($product["name"]) ?>"
                        data-price="<?= $price ?>"
                        data-available="<?= $product["is_available"]?>"
                        data-discount="<?= $product["procent"]?>">

                            <img 
                                src="<?=IMG_P_URL . $product["img"] ?>"
                                class="card-img-top h2 text-center p-0 m-0"
                                alt="<?= $product["name"] ?>"
                            >

                            <div class="p-2 d-flex flex-column flex-grow-1">

                                <h2 class="fw-bold">
                                    <?= $product["name"] ?>
                                </h2>

                                <small>
                                    <?= $product["description"] ?>
                                </small>

                                <div class="d-flex justify-content-end mt-auto p-0 m-0 gap-2">
                                    <?php
                                    if(!$noDiscount)
                                    {
                                    ?>
                                    <small
                                        class="fw-bold p-0 m-0 mt-auto text-decoration-line-through">
                                        <?= $product["price"] * $qty ?> zł
                                    </small>
                                    <?php } ?>
                                    <p
                                    class="text-end m-0 fw-bold mt-auto
                                    <?= $noDiscount ? '' : 'h4 text-warning' ?>">
                                    <?= $price * $qty ?> zł
                                </p>
                                </div>
                                

                            <!-- PRZYCISKI -->
                            <div class="d-flex gap-2 m-0 justify-content-center">
                                 <form class="cartTrash w-25 m-0">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-outline-danger btn-sm w-75">
                                        🗑️
                                    </button>
                                </form>

                                <!-- MINUS -->
                                <form class="cartRemove w-25 m-0">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-danger btn-sm w-100">
                                        -
                                    </button>
                                </form>

                                <!-- QTY -->
                                <span class="align-self-center h5 m-0">
                                    <?= $qty ?>
                                </span>

                                <!-- PLUS -->
                                <form class="cartAdd w-25 m-0">
                                    <input 
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-success btn-sm w-100">
                                        +
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>
                <?php } ?>

            </div>

        </section>
    </main>


    <?php include "popups.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>