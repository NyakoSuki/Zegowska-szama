<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";


// INITIALIZE CART
if (!isset($_SESSION["cart"]))
{
    $_SESSION["cart"] = [];
}


// INPUT DATA
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);


// ADD PRODUCT TO CART
if (isset($_POST["id"]) && $id)
{
    $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + 1;
}

echo json_encode([
    "status" => "ok",
    "cart" => $_SESSION["cart"]
]);