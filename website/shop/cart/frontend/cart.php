<?php

    session_start();

    require_once dirname(__DIR__, 4) . "/config.php";

    include DB_PATH;


    $cart = $_SESSION['cart'] ?? [];

    echo "<h1>Twój koszyk</h1>";

    if (empty($cart)) {
        echo "Koszyk jest pusty";
        exit;
    }

    $counts = array_count_values($cart);

    foreach ($counts as $id => $qty) {

        $result = $connection->query("SELECT name, price FROM products WHERE id = '$id'");
        $product = $result->fetch_assoc();

        echo "<div>";
            echo "<h3>".$product['name']."</h3>";
            echo "Cena: ".$product['price']." zł<br>";
            echo "Ilość: ".$qty;
        echo "</div><hr>";
    }

?>