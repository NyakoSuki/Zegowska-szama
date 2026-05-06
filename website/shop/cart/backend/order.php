<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;


$cart = $_SESSION["cart"] ?? [];
if (empty($cart)) {
    $_SESSION["producterror"] = "Koszyk jest pusty";
    header("Location: " . CART_F_URL . "cart.php");
    exit;
}

// Pobierz tylko produkty które są w koszyku
$ids = implode(",", array_map('intval', array_keys($cart)));

$products = $connection->query("
    SELECT id, name, stock, is_available, price
    FROM products
    WHERE id IN ($ids)
");

$removedProducts = [];

while ($product = $products->fetch_assoc()) {
    $id = $product["id"];
    $qty = $cart[$id];

    if (!$product["is_available"] || $product["stock"] < $qty) {
        $removedProducts[] = $product["name"];
        unset($_SESSION["cart"][$id]);
    }
}

if (!empty($removedProducts)) {
    $_SESSION["producterror"] = implode(", ", $removedProducts);
    header("Location: " . CART_F_URL . "cart.php");
    exit;
}
// START TRANSACTION
$connection->begin_transaction();

try
{
    // INPUT DATA
    $userId = $_SESSION["id"];
    $totalPrice = 0;


    // GUARD CLAUSE
    if (empty($cart)) throw new Exception("Cart is empty");


    // GET PRODUCT PRICES
    $stmt = $connection->prepare
    ("
        SELECT price 
        FROM products 
        WHERE id = ?
    ");
        if (!$stmt) throw new Exception("SQL prepare error");


    foreach ($cart as $id => $qty)
    {
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) throw new Exception("SQL execute error");

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) throw new Exception("Product not found");

        $totalPrice += $row["price"] * $qty;
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


    foreach ($cart as $id => $qty)
    {
        $stmt->bind_param("iii", $orderId, $id, $qty);

        if (!$stmt->execute()) throw new Exception("SQL execute error");
    }


    // COMMIT TRANSACTION
    $connection->commit();


    // CLEAR CART
    $_SESSION["cart"] = [];
    $_SESSION["error"] = "none";

    header("Location: " . CART_F_URL . "cart.php");
    exit;
}
catch (Exception $e)
{
    // ROLLBACK ON ERROR
    $connection->rollback();
    exit("Transaction failed " . $e->getMessage());
}