<?php

    require_once dirname(__DIR__, 3) . "/config.php";
    require_once BLOCKER_PATH;

    include DB_PATH;


    if (!isset($_SESSION['cart'])) 
    {
        $_SESSION['cart'] = [];
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>variables.css">
    <link rel="stylesheet" href="<?=CSS_URL?>header.css">
    <link rel="stylesheet" href="<?=CSS_URL?>home.css">
    <link rel="stylesheet" href="<?=CSS_URL?>menu.css">
</head>
<body>
    <header class="container-fluid sticky-top p-3">
        <div class="top row align-items-center">

            <!-- LOGO -->
            <div class="col-md-8 col-sm-7">
                <a href="<?=HOME_F_URL?>home.php" class="d-inline-block">
                    <img src="<?=IMG_URL?>logo.png" class="img-fluid logo-img" alt="logo">
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-md-4 col-sm-5 col-7 text-end">
                <a href="<?=ACCOUNT_F_URL?>account.php" class="btn btn-outline-light btn-sm">Account</a>
                <a href="<?=CART_F_URL?>cart.php" class="btn btn-outline-light btn-sm">Cart</a>
                <button type="button" class="btn btn-outline-light btn-sm menuBtn">Menu</button>
            </div>

        </div>
    </header>
    <main>
        <section class="products p-3">

            <div class="row g-4">

                <?php
                $products = $connection->query
                ("
                    SELECT id, name, description, price, stock, is_available, img 
                    FROM products
                ");

                while ($product = $products->fetch_assoc()) 
                {
                    $disabled = $product["is_available"] == 0;
                ?>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">

                        <div class="rounded-2 h-100 d-flex flex-column <?= $disabled ? 'opacity-50' : '' ?> product">

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

                                <p class="fw-bold mt-auto">
                                    <?= $product["price"] ?> zł
                                </p>

                                <form method="POST" action="<?=CART_B_URL?>cartadd.php">
                                    <input type="hidden" name="id" value="<?= $product["id"] ?>">

                                    <button class="w-100 rounded" <?= $disabled ? 'disabled' : '' ?>>
                                        Dodaj do koszyka
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                <?php } ?>

                <div class="col-12 col-sm-6 col-md-4 col-lg-3 menu disabled">
 
                </div>

            </div>

        </section>
    </main>
    <footer>

    </footer>

    
    <script src="<?=JS_URL?>menu.js"></script>
</body>
</html>