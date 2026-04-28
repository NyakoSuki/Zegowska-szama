<?php

require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;

include DB_PATH;

$connection->begin_transaction();


try
{
    $userId = $_SESSION["id"];
    $totalPrice = 0;
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) throw new Exception("SQL cart error");

    $counts = array_count_values($cart);


    $stmt = $connection->prepare("SELECT price FROM products WHERE id = ?");

    if (!$stmt) throw new Exception("SQL prepare error");

    foreach ($counts as $id => $qty)
    {
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) throw new Exception("SQL execute error");

        $result = $stmt->get_result();

        $product = $result->fetch_assoc();
        if (!$product) throw new Exception("Product not found");

        $totalPrice += $product["price"] * $qty;
    }


    $stmt = $connection->prepare
    ("
    INSERT INTO orders (user_id, total_price)
    VALUES (?, ?)
    ");
    
    if (!$stmt) throw new Exception("SQL prepare error");

    $stmt->bind_param
    (
        "id",
        $userId,
        $totalPrice
    );

    if (!$stmt->execute()) throw new Exception("SQL execute error");

    
    $orderId = $connection->insert_id;

    $stmt = $connection->prepare
    ("
    INSERT INTO ordered_products (order_id, product_id, quantity)
    VALUES (?, ?, ?)
    ");

    if (!$stmt) throw new Exception("SQL prepare error");

    foreach ($counts as $id => $qty) 
    {
        $stmt->bind_param
        (
            "iii",
            $orderId,
            $id,
            $qty
        );

        if (!$stmt->execute()) throw new Exception("SQL execute error");
    }


    $connection->commit();

    $_SESSION['cart'] = [];
    header("Location: " . CART_F_URL . "cart.php");
    exit;
}

catch (Exception $e) 
{
    $connection->rollback();
    exit("Transaction failed");
}