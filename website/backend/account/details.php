<?php
require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;

if (!isset($_POST['order_id'])) exit;

$order_id = $_POST['order_id'];

$stmt = $connection->prepare("
    SELECT
        products.name,
        ordered_products.quantity
    FROM ordered_products
    JOIN products
        ON products.id = ordered_products.product_id
    WHERE ordered_products.order_id = ?
");

$stmt->bind_param("i", $order_id);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='border-bottom p-2'>";
    echo "<b>{$row['name']}</b> x {$row['quantity']}";
    echo "</div>";
}