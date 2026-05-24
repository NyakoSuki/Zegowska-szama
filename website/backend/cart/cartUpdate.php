<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

if($_POST["action"] === "add")
{
    // Create cart if it does not exist
    if (!isset($_SESSION["cart"]))
    {
        $_SESSION["cart"] = [];
    }
    // Get product data
    $id = (int)($_POST["id"] ?? '');
    $name = $_POST["name"] ?? '';
    $quantity = (int)($_POST["quantity"] ?? '');
    $left = (int)($_POST["left"] ?? 1);

     // Validate product
    if(empty($id))
    {
        http_response_code(404);
        exit("Produkt nie istnieje");
    }

    // Minimum quantity validation
    if($quantity < 1)
    {
        http_response_code(409);
        exit("Nie możesz dodawać ilości mniejszych niż 1");
    }

    // Limit of 10 identical products
    if(($_SESSION["cart"][$id] ?? 0) + 1 > 10)
    {
        http_response_code(409);
        exit("Nie możesz mieć więcej niż 10 takich samych produktów w koszyku naraz! Posiadasz: " . ($_SESSION['cart'][$id] ?? 0));
    }

    // Check product stock
    if(($_SESSION["cart"][$id] ?? 0) + 1 > $left && $left !== -1)
    {
        http_response_code(409);
        exit("Przepraszamy ale ten produkt nie jest dostępny w większej ilości");
    }
    
    // Add product to cart
    $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + 1;

    exit("Pomyślnie dodano \"" . $name . "\"\n w ilości: " . $quantity);
}

if($_POST["action"] === "remove")
{
    $id = (int)($_POST["id"] ?? 0);

    // Remove product completely from cart
    if ($_SESSION["cart"][$id] > 1)
    {
        if ($id && isset($_SESSION["cart"][$id]))
        {
            $_SESSION["cart"][$id]--;
        }
    }
}

if($_POST["action"] === "trash")
{
    $id = (int)($_POST["id"] ?? 0);

    if ($id && isset($_SESSION["cart"][$id]))
    {
        unset($_SESSION["cart"][$id]);
    }
    exit("Pomyślnie usunięto");
}

if($_POST["action"] === "update")
{
    // Get updated product data
    $id = (int)($_POST["id"] ?? 0);
    $qty = (int)($_POST["quantity"] ?? 1);
    $left = (int)($_POST["left"] ?? 1);

    if($qty > $left && $left !== -1)
    {
        $_SESSION["cart"][$id] = $left;
        exit("Przepraszamy ale ten produkt nie jest dostępny w większej ilości");
    }

    // Update product quantity
    if($id > 0 && $qty > 0 && $qty < 11)
    {
        $_SESSION["cart"][$id] = $qty;
    }
    exit;
}