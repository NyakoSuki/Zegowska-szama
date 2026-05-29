<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

if (!isset($_POST['order_id'])) exit;

$order_id = $_POST['order_id'];

$stmt = $connection->prepare("
    SELECT
        products.name,
        products.price,
        ordered_products.quantity,
        (products.price * ordered_products.quantity) AS subtotal
    FROM ordered_products
    JOIN products ON products.id = ordered_products.product_id
    WHERE ordered_products.order_id = ?
");

$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
    $total += $row['subtotal'];
}

foreach ($rows as $row) {
    echo "<div class='d-flex justify-content-between align-items-center border-bottom py-2'>";
    echo   "<div>";
    echo     "<span class='fw-semibold'>" . htmlspecialchars($row['name']) . "</span><br>";
    echo     "<small class='text-muted'>{$row['quantity']} × " . number_format($row['price'], 2) . " zł</small>";
    echo   "</div>";
    echo   "<span class='fw-bold'>" . number_format($row['subtotal'], 2) . " zł</span>";
    echo "</div>";
}

echo "<div class='d-flex justify-content-between align-items-center pt-2'>";
echo   "<span class='fw-bold'>Razem</span>";
echo   "<span class='fw-bold text-success fs-5'>" . number_format($total, 2) . " zł</span>";
echo "</div>";