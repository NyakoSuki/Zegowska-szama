<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);


// DECREASE PRODUCT QUANTITY IN CART
if (isset($_SESSION["cart"][$id]))
{
    $_SESSION["cart"][$id]--;

    // REMOVE PRODUCT IF QUANTITY IS ZERO OR LESS
    if ($_SESSION["cart"][$id] <= 0)
    {
        unset($_SESSION["cart"][$id]);
    }
}


// REDIRECT TO CART
header("Location: " . CART_F_URL . "cart.php");
exit;