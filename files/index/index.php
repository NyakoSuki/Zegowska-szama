<?php

include "data_base.php";

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
            <img src="../../images/account.png" alt="account" class="accountImg">
            <img src="../../images/cart.png" alt="cart" class="cartImg">
            <img src="../../images/menu.png" alt="menu" class="menuImg">
        </section>

    </header>
    <main>
        <section class="products">
            <?php

                $numberOfRows = $connection->query("SELECT id FROM products");
                $products = $connection->query("SELECT name, description, price, stock, is_available, img FROM products");

                for($i = 0; $i < $numberOfRows->num_rows; $i++)
                    {
                        $product = $products->fetch_assoc();
                        echo "<div class='product'>";
                            echo "<img src='".$product["img"]."'>";
                            echo "<h2>".$product["name"]."</h2>";
                            echo $product["price"]."zł";
                        echo "</div>";
                    }

            ?>

        </section>
    </main>
    <footer>

    </footer>
</body>
</html>