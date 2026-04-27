<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


$id = (int)($_POST["id"] ?? 0);
$name = $_POST["name"] ?? '';
$description = $_POST["description"] ?? '';
$price = (float)($_POST["price"] ?? 0);
$stock = (int)($_POST["stock"] ?? 0);
$is_available = isset($_POST["is_available"]) ? '1' : '0';
$img = $_POST["img"] ?? '';

if (empty($id) || empty($name) || empty($price)) exit;

$stmt = $connection->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, is_available = ?, img = ? where id = ?");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param(
    "ssdiisi",
    $name,
    $description,
    $price,
    $stock,
    $is_available,
    $img,
    $id
);

if (!$stmt->execute()) exit("SQL execute error");

header("Location: " . ACCOUNT_F_URL . "admin.php");
exit;