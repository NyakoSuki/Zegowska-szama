<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

$cart = $_SESSION["cart"] ?? [];
if (empty($cart)) {
    $_SESSION["error"] = "empty";
    header("Location: " . PUBLIC_URL . "html/cart/cart.php");
    exit;
}

$ids = implode(",", array_map('intval', array_keys($cart)));

$products = $connection->query("
    SELECT id, name, stock, is_available, price
    FROM products
    WHERE id IN ($ids)
");

$removedProducts = [];

while ($product = $products->fetch_assoc()) {
    $id    = (int)$product["id"];
    $stock = (int)$product["stock"];
    $qty   = (int)$cart[$id];

    if (!$product["is_available"] || ($qty > $stock && $stock !== -1)) {
        $removedProducts[] = $product["name"];
        unset($_SESSION["cart"][$id]);
    }
}

if (!empty($removedProducts)) {
    $_SESSION["error"]        = "unavailable";
    $_SESSION["producterror"] = implode(", ", $removedProducts);
    header("Location: " . PUBLIC_URL . "html/cart/cart.php");
    exit;
}

$connection->begin_transaction();

try
{
    $userId     = $_SESSION["id"];
    $totalPrice = 0;

    if (empty($cart)) throw new Exception("Cart is empty");


    // GET PRODUCT PRICES (z rabatem)
    $stmt = $connection->prepare("
        SELECT p.id, p.name, p.price,
               CASE
                   WHEN d.id IS NOT NULL AND NOW() BETWEEN d.start_date AND d.end_date
                   THEN ROUND(p.price * (1 - d.procent / 100), 2)
                   ELSE p.price
               END AS final_price
        FROM products p
        LEFT JOIN discounted_products dp ON dp.product_id = p.id
        LEFT JOIN discounts d            ON d.id = dp.discount_id
                                        AND NOW() BETWEEN d.start_date AND d.end_date
        WHERE p.id = ?
    ");
    if (!$stmt) throw new Exception("SQL prepare error");

    $productData = [];

    foreach ($cart as $id => $qty)
    {
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) throw new Exception("SQL execute error");

        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();
        if (!$row) throw new Exception("Product not found");

        $productData[$id] = [
            'name'        => $row['name'],
            'final_price' => $row['final_price'],
        ];

        $totalPrice += $row['final_price'] * $qty;
    }


    // CREATE ORDER
    $stmt = $connection->prepare("
        INSERT INTO orders (user_id, name, email, total_price)
        VALUES (?, ?, ?, ?)
    ");
    if (!$stmt) throw new Exception("SQL prepare error");

    $stmt->bind_param("issd", $userId, $_POST["name"], $_POST["email"], $totalPrice);
    if (!$stmt->execute()) throw new Exception("SQL execute error");

    $orderId = $connection->insert_id;


    // INSERT ORDERED PRODUCTS
    $stmt = $connection->prepare("
        INSERT INTO ordered_products (order_id, product_id, name, price, quantity)
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmt) throw new Exception("SQL prepare error");

    foreach ($cart as $id => $qty)
    {
        $pName  = $productData[$id]['name'];
        $pPrice = $productData[$id]['final_price'];

        $stmt->bind_param("iisdi", $orderId, $id, $pName, $pPrice, $qty);
        if (!$stmt->execute()) throw new Exception("SQL execute error");
    }


    // UPDATE STOCK
    $stmt = $connection->prepare("
        UPDATE products
        SET stock = CASE
            WHEN stock = -1 THEN -1
            ELSE stock - ?
        END
        WHERE id = ?
        AND (stock >= ? OR stock = -1)
    ");
    if (!$stmt) throw new Exception("SQL prepare error");

    foreach ($cart as $id => $qty)
    {
        $stmt->bind_param("iii", $qty, $id, $qty);
        if (!$stmt->execute()) throw new Exception("SQL execute error");
    }


    $connection->commit();

    $_SESSION["cart"]  = [];
    $_SESSION["error"] = "none";

    header("Location: " . PUBLIC_URL . "html/cart/cart.php");
    exit;
}
catch (Exception $e)
{
    $connection->rollback();
    exit("Transaction failed: " . $e->getMessage());
}