<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";

$id = (int)$_POST["id"];

if (isset($_SESSION["cart"][$id]))
{

    $_SESSION["cart"][$id]--;

    if ($_SESSION["cart"][$id] <= 0)
    {
        unset($_SESSION["cart"][$id]);
    }
}

header("Location: " . CART_F_URL . "cart.php");
exit;