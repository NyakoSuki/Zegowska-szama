<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once SITE_BLOCKER;
include DATABASE_FILE;

$cart = $_SESSION["cart"] ?? [];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=CSS_URL?>main.css">
</head>

<body class="<?=$_SESSION['theme']?>">
    <?php
    $site = "cart";
    include HTML_PATH . "/shared/header.php";
    ?>
    <main>
        <section class="p-3 mb-3">

            <div class="row g-2 d-flex justify-content-center">

                <div class="col-12 col-md-6 col-lg-3">
                    <button
                        id="cartOrderBtn"
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
                            echo "<h4 class='text-success mb-0'>Pomyślnie złożono zamówienie</h4>";
                            break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>
            </div>

        </section>

        <!--
        * ====================PRODUCTS====================
         * generated in productCreate.php
        * ==================================================
        -->
        <?php include SHARED_B . "productCreate.php"?>

        
        <section class="p-3">
            <div class="row g-4">
                <?php
                
                
                while ($row = $query->fetch_assoc())
                {
                    $productId = (int)($row["id"]);
                    

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
                        <?= $isDiscounted ? 'border-3 border-warning' : ''?>"
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
                        <div class="d-flex row m-0 justify-content-center">
                             <form class="cartTrash col-6 m-0">
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $productId?>"
                                >
                                <button class="btn btn-outline-danger btn-sm w-50">
                                    🗑️
                                </button>
                            </form>

                            <!-- QTY -->
                            <input
                                id="cartQuantityInp"
                                name="quantity"
                                class="col-6"
                                value="<?= $quantity?>"
                                type="number"
                                placeholder=""
                            >
                        
                        </div>

                        </div>
                    </div>

                </div>
                <?php } ?>

            </div>

        </section>
    </main>


    <?php include "popup.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>