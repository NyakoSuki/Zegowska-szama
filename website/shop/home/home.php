<?php

    require_once dirname(__DIR__, 3) . "/config.php";
    require_once BASE_PATH . "/authorization.php";

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
    <link rel="stylesheet" href="<?=CSS_URL?>home.css">
    <title>Zegowska Szama</title>
</head>
<body>
    <header>
        <button class="logo"></button>
        <nav>
            <button class="account"></button>
            <button class="cart"></button>
            <button class="menu"></button>
        </nav>

    </header>

    <main>
        <section class="products">
            <?php

                $products = $connection->query("SELECT id, name, description, price, stock, is_available, img FROM products");

                while($product = $products->fetch_assoc())
                    {                      
                        echo "<div class='product'>";
                            echo "<div class='img'>";
                                echo "<img src='".$product["img"]."' class='".($product["is_available"] == 0 ? "gray" : "")."'>";
                            echo "</div>";

                            echo "<h1>".$product["name"]."</h1>";
                            echo "<h4>".$product["description"]."</h4>";
                            echo "<p>".$product["price"]." zł</p>";

                            echo "<form method='POST' action='" . CART_B_URL . "add.php'>";
                                echo "<input type='hidden' name='id' value='".$product["id"]."'>";
                                echo "<button type='submit' class='".($product["is_available"] == 0 ? "gray" : "")."'".($product["is_available"] == 0 ? "disabled" : "").">Dodaj do koszyka</button>";
                            echo "</form>";
                        echo "</div>";
                    }

            ?>

        </section>
    </main>
    <footer>

    </footer>

    
    <script src="<?=JS_URL?>home-navi.js"></script>
</body>
</html>