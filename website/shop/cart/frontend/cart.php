<?php

require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;

include DB_PATH;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>variables.css">
    <link rel="stylesheet" href="<?=CSS_URL?>header.css">
    <link rel="stylesheet" href="<?=CSS_URL?>cart.css">
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
            </div>

        </div>
    </header>
    <main>

        <?php
        $cart = $_SESSION['cart'] ?? [];

        echo "<h1>Twój koszyk</h1>";

        if (empty($cart)) 
        {
            echo "Koszyk jest pusty";
            exit;
        }

        $counts = array_count_values($cart);

        foreach ($counts as $id => $qty) 
        {
            $result = $connection->query("SELECT name, price FROM products WHERE id = '$id'");
            $product = $result->fetch_assoc();

            echo "<div>";
                echo "<h3>".$product['name']."</h3>";
                echo "Cena: ".$product['price']." zł<br>";
                echo "Ilość: ".$qty;
            echo "</div><hr>";
        }
        ?>

    </main>


    <script src="<?=JS_URL?>navi.js"></script>
</body>
</html>