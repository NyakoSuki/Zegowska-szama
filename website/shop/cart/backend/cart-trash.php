<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";

// INPUT DATA
$id = (int)($_POST["id"] ?? 0);


// DECREASE PRODUCT QUANTITY IN CART
if ($id && isset($_SESSION["cart"][$id]))
{
    unset($_SESSION["cart"][$id]);
}