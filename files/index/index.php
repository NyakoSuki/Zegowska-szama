<?php

session_start();

include "data_base.php";

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
    <link rel="stylesheet" href="./style.css">
    <title>Zegowska Szama</title>
</head>
<body>
    <header>
        <section>
            <img src="../../images/zegowska_szama_logo.png" alt="logo">
        </section>
        <section>
            <img src="../../images/account.png" alt="account" class="account">
            <img src="../../images/cart.png" alt="cart" class="cart">
            <img src="../../images/menu.png" alt="menu" class="menu">
        </section>

    </header>
    <main>
        <section class="products">
            <?php

                $products = $connection->query("SELECT id, name, description, price, stock, is_available, img FROM products");

                while($product = $products->fetch_assoc())
                    {                      
                        echo "<div class='product'>";
                            echo "<img src='".$product["img"]."'>";
                            echo "<h2>".$product["name"]."</h2>";
                            echo "<h4>".$product["description"]."</h4>";
                            echo $product["price"]." zł";

                            echo "<form method='POST' action='add_to_cart.php'>";
                                echo "<input type='hidden' name='id' value='".$product["id"]."'>";
                                echo "<button type='submit'>Dodaj do koszyka</button>";
                            echo "</form>";
                        echo "</div>";
                    }

            ?>

        </section>
    </main>
    <footer>

    </footer>
    <script src="app.js"></script>
</body>
</html>