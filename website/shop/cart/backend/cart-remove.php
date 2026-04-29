<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);


// DECREASE PRODUCT QUANTITY IN CART
if ($id && isset($_SESSION["cart"][$id]))
{
    $_SESSION["cart"][$id]--;

    // REMOVE PRODUCT IF QUANTITY IS ZERO OR LESS
    if ($_SESSION["cart"][$id] <= 0)
    {
        unset($_SESSION["cart"][$id]);
    }
}


// REDIRECT TO CART