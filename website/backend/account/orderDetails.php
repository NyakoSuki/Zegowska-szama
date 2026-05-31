<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

if (!isset($_POST['order_id'])) exit;

$order_id = $_POST['order_id'];

$stmt = $connection->prepare("
    SELECT
        op.name,
        op.price                     AS paid_price,
        p.price                      AS original_price,
        op.quantity,
        (op.price * op.quantity)     AS subtotal
    FROM ordered_products op
    JOIN products p ON p.id = op.product_id
    WHERE op.order_id = ?
");

$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$rows  = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
    $total += $row['subtotal'];
}

foreach ($rows as $row)
{
    $wasDiscounted = $row['paid_price'] < $row['original_price'];

    echo "<div class='d-flex justify-content-between align-items-center border-bottom py-2'>";
    echo   "<div>";
    echo     "<span class='fw-semibold'>" . htmlspecialchars($row['name']) . "</span>";

    if ($wasDiscounted) {
        echo "<span class='badge bg-danger ms-2'>Przecena</span>";
    }

    echo     "<br>";
    echo     "<small class='text-muted'>{$row['quantity']} × " . number_format($row['paid_price'], 2) . " zł</small>";

    if ($wasDiscounted) {
        echo " <small class='text-decoration-line-through text-muted'>" . number_format($row['original_price'], 2) . " zł</small>";
    }

    echo   "</div>";
    echo   "<span class='fw-bold'>" . number_format($row['subtotal'], 2) . " zł</span>";
    echo "</div>";
}

echo "<div class='d-flex justify-content-between align-items-center pt-2'>";
echo   "<span class='fw-bold'>Razem</span>";
echo   "<span class='fw-bold text-success fs-5'>" . number_format($total, 2) . " zł</span>";
echo "</div>";