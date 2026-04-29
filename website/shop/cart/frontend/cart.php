<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
include BASE_PATH . "config.js.php";


// CREATING CART
$cart = $_SESSION["cart"] ?? [];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>cart.css">
</head>

<body>
    <header class="container-fluid sticky-top p-3">
        <div class="top row align-items-center">

            <!-- LOGO -->
            <div class="col-md-8 col-sm-7">
                <a 
                    href="<?=HOME_F_URL?>home.php"
                    class="d-inline-block">
                        <img 
                            src="<?=IMG_URL?>logo.png"
                            class="img-fluid logo-img" 
                            alt="logo"
                        >
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-md-4 col-sm-5 col-7 text-end">
                <a
                    href="<?=ACCOUNT_F_URL?>account.php"
                    class="btn btn-outline-light btn-sm">
                    Account
                </a>
                <a
                    href="<?=CART_F_URL?>cart.php"
                    class="btn btn-outline-light btn-sm">
                    Cart
                </a>
                <a
                    href="<?=HOME_F_URL?>home.php"
                    class="btn btn-outline-light btn-sm">
                    Home
                </a>
            </div>

        </div>
    </header>


    <main>
        <section class="products p-3">

            <div class="d-flex flex-column flex-sm-row gap-2 mb-3 col-12 col-lg-6 offset-lg-3">

                <!-- ZAMÓWIENIE -->
                <form 
                    action="<?=CART_B_URL?>order.php" 
                    method="post"
                    onsubmit="return confirm('Na pewno chcesz złożyć zamówienie?');"
                    class="flex-fill col-lg-3 col-md-6 col-12 m-1">

                    <button type="submit"
                        class="btn btn-outline-success w-100">
                        Zamów
                    </button>
                </form>

                <!-- CZYSZCZENIE -->
                <form 
                    action="<?=CART_B_URL?>cart-clear.php" 
                    method="post"
                    onsubmit="return confirm('Na pewno chcesz wyczyścić koszyk?');"
                    class="flex-fill col-lg-3 col-md-6 col-12 m-1">

                    <button type="submit"
                        class="btn btn-outline-danger w-100">
                        Wyczyść koszyk
                    </button>
                </form>

            </div>

            <div class="row g-4">

                <?php
                // POBRANIE PRODUKTÓW
                $products = $connection->query
                ("
                    SELECT id, name, description, price, stock, img 
                    FROM products
                ");

                while ($product = $products->fetch_assoc()) 
                {
                    $id = $product["id"];

                    // JEŚLI PRODUKT NIE JEST W KOSZYKU
                    if (!isset($cart[$id])) continue;

                    $qty = $cart[$id];
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">

                    <div 
                        class="rounded-2 h-100 d-flex flex-column product">

                        <img 
                            src="<?= $product["img"] ?>" 
                            class="rounded-top-1 card-img-top"
                            alt="<?= $product["name"] ?>"
                        >

                        <div class="p-2 d-flex flex-column flex-grow-1">

                            <h5 class="text-center">
                                <?= $product["name"] ?>
                            </h5>

                            <p class="small">
                                <?= $product["description"] ?>
                            </p>

                            <p class="text-center m-0 fw-bold">
                                Suma: <?= $product["price"] * $qty ?> zł
                            </p>

                            <!-- PRZYCISKI -->
                            <div class="d-flex gap-2 mt-2 justify-content-center">

                                <!-- MINUS -->
                                <form class="cartRemove w-25">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-outline-danger btn-sm w-100">
                                        -
                                    </button>
                                </form>

                                <!-- ILOŚĆ -->
                                <span class="align-self-center h4">
                                    <?= $qty ?>
                                </span>

                                <!-- PLUS -->
                                <form class="cartAdd w-25">
                                    <input 
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-outline-success btn-sm w-100">
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


    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>