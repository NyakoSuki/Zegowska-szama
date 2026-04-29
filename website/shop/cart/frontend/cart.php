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
            <div class="col-sm-3 col-9 mb-2 d-flex justify-content-sm-end justify-content-start">
                <a 
                    href="https://www.zs4.oswiata.tychy.pl/"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>logo.svg"
                            class="img-fluid img-logo" alt="logo"
                        >
                </a>
            </div>

            <div class="col-lg-5 col-0 mb-2 d-lg-flex d-none justify-content-md-start">
                <a 
                    href="<?=HOME_F_URL?>home.php"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>zegowska-szama2.png"
                            class="img-fluid img-logo" alt="zegowska-szama"
                        >
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-lg-4 col-sm-9 col-3 d-flex justify-content-end gap-2">
                <a
                    href="<?=ACCOUNT_F_URL?>account.php"
                    class="btn btn-dark">
                    Konto
                    </a>
                <a
                    href="<?=CART_F_URL?>cart.php"
                    class="btn btn-dark">
                    Koszyk
                </a>
                <a
                    href="<?=HOME_F_URL?>home.php"
                    class="btn btn-dark">
                    Sklep
                </a>
            </div>

        </div>
    </header>


    <main>
        <section class="products p-3">

            <div class="d-flex flex-column flex-sm-row gap-2 mb-3 col-12 col-lg-6 offset-lg-3">

                okienko cena koncowa i zaplac i wtedy wyslij zamoweinie do bazy

                <!-- ZAMÓWIENIE -->
                <form 
                    action="<?=CART_B_URL?>order.php" 
                    method="post"
                    class="flex-fill col-lg-3 col-md-6 col-12 m-1">

                    <button type="submit"
                        class="btn btn-success w-100">
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
                        class="btn btn-danger w-100">
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

                            <h4 class="text-center">
                                <?= $product["name"] ?>
                            </h4>

                            <p class="small">
                                <?= $product["description"] ?>
                            </p>

                            <p class="text-center m-0 fw-bold mt-auto">
                                Suma: <?= $product["price"] * $qty ?> zł
                            </p>

                            <!-- PRZYCISKI -->
                            <div class="d-flex gap-2 m-0 justify-content-center">
                                 <form class="cartTrash w-25">
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
                                <form class="cartRemove w-25">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn btn-danger btn-sm w-100">
                                        -
                                    </button>
                                </form>

                                <!-- ILOŚĆ -->
                                <span class="align-self-center h5">
                                    <?= $qty ?>
                                </span>

                                <!-- PLUS -->
                                <form class="cartAdd w-25">
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


    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>