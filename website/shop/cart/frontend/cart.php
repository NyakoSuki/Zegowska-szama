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
        <section class="p-3 mb-3">

            <div class="row g-2 d-flex justify-content-center">

                <div class="col-12 col-md-6 col-lg-3">
                    <button
                        type="button"
                        class="btn btn-success w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#orderModal"
                    >
                        Zamów
                    </button>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <button
                        type="button"
                        class="btn btn-danger w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#clearModal"
                    >
                        Wyczyść koszyk
                    </button>
                </div>

            </div>

            <div class="mt-3 col-12">
                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"])
                    {
                        case "" :
                            echo "<h4 class='text-danger mb-0'>Przepraszamy, ale" . $_SESSION["error"] . " nie jest już dostępny</h4>";
                            break;

                        case "none" :
                            echo "<h4 class='text-danger mb-0'>Pomyślnie złożono zamówienie</h4>";
                            break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>
            </div>

        </section>

        <section class="p-3">
            <div class="row g-4">
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

                $totalPrice = 0;
                while ($row = $query->fetch_assoc())
                {
                    $productId = (int)($row["id"]);
                    if (!isset($cart[$productId])) continue;

                    $productName = $row["name"];
                    $productDescription = $row["description"];
                    $productType = $row["type"];
                    $productPrice = (float)($row["price"]);
                    $productStock = (int)($row["stock"]);
                    $productIsAvailable = (int)($row["is_available"]);
                    $productIsActive = (int)($row["is_active"]);
                    $productImg = $row["img"];

                    $isAvailable = ($productIsAvailable === 1 && ($productStock === -1 || $productStock > 0));
                    if(!$isAvailable)
                    {
                        unset($_SESSION["cart"]["id"]);
                        continue;
                    }
                    $isActive = ($productIsActive === 1);
                    if(!$isActive)
                    {
                        unset($_SESSION["cart"]["id"]);
                        continue;
                    }

                    $discountProcent = (int)($row["procent"]);
                    $discountStartDate = $row["start_date"];
                    $discountEndDate = $row["end_date"];

                    $quantity = $cart[$productId];

                    $isDiscounted = $discountProcent !== 0;
                    if($isDiscounted)
                        $truePrice = round($productPrice * (1 - $discountProcent / 100), 2);

                    $totalPrice += $productPrice * $quantity;
                ?>
                <div
                    class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2"
                >
                    <div 
                        class="product
                        h-100 d-flex flex-column border p-1
                        <?= $isDiscounted ? 'border-3 border-warning' : 'border-dark'?>"
                    >
                        <img 
                            src="<?=IMG_P_URL . $productImg ?>"
                            alt="<?= $productName ?>"
                            class="card-img-top h2 text-center p-0 m-0 align-self-center
                            <?php echo ($productType === 'drink') ? 'w-25' : ''?>"
                        >
                        <div
                            class="p-2 d-flex flex-column flex-grow-1"
                        >
                            <h3
                                class="fw-bold"
                            >
                                <?= $productName ?>
                            </h3>
                            <small>
                                <?= $productDescription?>
                            </small>
                            
                            <div
                                class="d-flex mt-auto p-0 m-0 gap-2 w-100"
                            >
                                <p
                                    class="fw-bold p-0 m-0 mt-auto ms-auto
                                    <?= $isDiscounted ? 'text-decoration-line-through' : ''?>
                                ">
                                    <?= $productPrice * $quantity?> zł
                                </p>
                                <p
                                    class="fw-bold p-0 m-0 h4 text-warning"
                                >
                                    <?= $isDiscounted ? $truePrice * $quantity : ''?>
                                </p>
                            </div>
                            
                        <!-- PRZYCISKI -->
                        <div class="d-flex gap-2 m-0 justify-content-center">
                             <form class="cartTrash w-25 m-0">
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $productId?>"
                                >
                                <button class="btn btn-outline-danger btn-sm w-75">
                                    🗑️
                                </button>
                            </form>
                            <!-- MINUS -->
                            <form
                                class="cartRemove w-25 m-0"
                            >
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $productId?>"
                                >
                                <button
                                    class="btn btn-danger btn-sm w-100"
                                >
                                    -
                                </button>
                            </form>
                            <!-- QTY -->
                            <span 
                                class="align-self-center h5 m-0"
                            >
                                <?= $quantity?>
                            </span>
                            <!-- PLUS -->
                            <form
                                class="cartAdd w-25 m-0"
                            >
                                <input 
                                    type="hidden"
                                    name="id"
                                    value="<?= $productId?>"
                                >
                                <button
                                    class="btn btn-success btn-sm w-100"
                                >
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