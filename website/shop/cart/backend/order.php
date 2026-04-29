<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;


// START TRANSACTION
$connection->begin_transaction();

try
{
    // INPUT DATA
    $userId = $_SESSION["id"];
    $cart = $_SESSION["cart"] ?? [];
    $totalPrice = 0;


    // GUARD CLAUSE
    if (empty($cart)) throw new Exception("Cart is empty");


    // COUNT PRODUCTS
    $counts = array_count_values($cart);


    // GET PRODUCT PRICES
    $stmt = $connection->prepare
    ("
        SELECT price 
        FROM products 
        WHERE id = ?
    ");
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


    // CREATE ORDER
    $stmt = $connection->prepare
    ("
        INSERT INTO orders (user_id, total_price)
        VALUES (?, ?)
    ");
        if (!$stmt) throw new Exception("SQL prepare error");

    $stmt->bind_param("id", $userId, $totalPrice);

    if (!$stmt->execute()) throw new Exception("SQL execute error");

    $orderId = $connection->insert_id;


    // INSERT ORDERED PRODUCTS
    $stmt = $connection->prepare
    ("
        INSERT INTO ordered_products (order_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");
        if (!$stmt) throw new Exception("SQL prepare error");


    foreach ($counts as $id => $qty)
    {
        $stmt->bind_param("iii", $orderId, $id, $qty);

        if (!$stmt->execute()) throw new Exception("SQL execute error");
    }


    // COMMIT TRANSACTION
    $connection->commit();


    // CLEAR CART
    $_SESSION["cart"] = [];

    header("Location: " . CART_F_URL . "cart.php");
    exit;
}
catch (Exception $e)
{
    // ROLLBACK ON ERROR
    $connection->rollback();
    exit("Transaction failed");
}