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
        exit("Product does not exist");
    }

    // Minimum quantity validation
    if($quantity < 1)
    {
        http_response_code(409);
        exit("You cannot add less than 1 item");
    }

    // Limit of 10 identical products
    if(($_SESSION["cart"][$id] ?? 0) + 1 > 10)
    {
        http_response_code(409);
        exit("You cannot have more than 10 identical products in the cart! Current amount: " . ($_SESSION['cart'][$id] ?? 0));
    }

    // Check product stock
    if(($_SESSION["cart"][$id] ?? 0) + 1 > $left && $left !== -1)
    {
        http_response_code(409);
        exit("Sorry, this product is not available in a larger quantity");
    }

    // Add product to cart
    $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + 1;

    exit("Successfully added \"" . $name . "\"\n quantity: " . $quantity);
}

if($_POST["action"] === "remove")
{
    // Get product ID
    $id = (int)($_POST["id"] ?? 0);

    // Remove one product item
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
    // Get product ID
    $id = (int)($_POST["id"] ?? 0);

    // Remove product completely from cart
    if ($id && isset($_SESSION["cart"][$id]))
    {
        unset($_SESSION["cart"][$id]);
    }

    exit("Successfully removed");
}

if($_POST["action"] === "update")
{
    // Get updated product data
    $id = (int)($_POST["id"] ?? 0);
    $qty = (int)($_POST["quantity"] ?? 1);
    $left = (int)($_POST["left"] ?? 1);

    // Limit quantity to available stock
    if($qty > $left && $left !== -1)
    {
        $_SESSION["cart"][$id] = $left;
        exit("Sorry, this product is not available in a larger quantity");
    }

    // Update product quantity
    if($id > 0 && $qty > 0 && $qty < 11)
    {
        $_SESSION["cart"][$id] = $qty;
    }

    exit;
}