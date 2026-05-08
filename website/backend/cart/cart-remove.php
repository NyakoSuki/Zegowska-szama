<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);


// DECREASE PRODUCT QUANTITY IN CART
if ($_SESSION["cart"][$id] > 1)
{
    if ($id && isset($_SESSION["cart"][$id]))
    {
        $_SESSION["cart"][$id]--;
    }
}