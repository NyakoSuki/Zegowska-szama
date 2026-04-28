<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


// INPUT DATA
$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$price = (float)($_POST["price"] ?? 0);
$stock = (int)($_POST["stock"] ?? -1);
$is_available = isset($_POST["is_available"]) ? 1 : 0;
$img = $_POST["img"] ?? "";


// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($name) || empty($price)) exit;


// INSERT PRODUCT (WITH OR WITHOUT STOCK)
if ($stock === -1) 
{
    $stmt = $connection->prepare
    ("
        INSERT INTO products (name, description, price, stock, is_available, img)
        VALUES (?, ?, ?, NULL, ?, ?)
    ");
        if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param
    (
        "ssdis",
        $name,
        $description,
        $price,
        $is_available,
        $img
    );
}
else
{
    $stmt = $connection->prepare
    ("
        INSERT INTO products (name, description, price, stock, is_available, img)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param
    (
        "ssdiis",
        $name,
        $description,
        $price,
        $stock,
        $is_available,
        $img
    );
}


// EXECUTE QUERY
if (!$stmt->execute()) exit("SQL execute error");


// SUCCESS
header("Location: " . ADMIN_F_URL . "admin.php");
exit;