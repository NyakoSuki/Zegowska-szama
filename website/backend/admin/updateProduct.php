<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);

$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$type = $_POST["type"] ?? "";
$price = (float)($_POST["price"] ?? 0);
$stock = (int)($_POST["stock"]);
$isAvailable = isset($_POST["available"]) ? 1 : 0;
$isActive = isset($_POST["active"]) ? 1 : 0;
$img = $_POST["img"] ?? "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if(empty($name) || empty($price))exit;

// UPDATE PRODUCT
if ($action === "update")
{
    // GUARD CLAUSES
    if (empty($id)) exit("empty");


        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name = ?, description = ?, type = ?, price = ?, stock = ?, is_available = ?, is_active = ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "s s s d i i i s i",
            $name,
            $description,
            $type,

            $price,

            $stock,
            $isAvailable,
            $isActive,

            $img,
            
            $id
        );



    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}


if ($action === "add")
{
    // GUARD CLAUSES

    // UPDATE WITH NULL STOCK
   
        $stmt = $connection->prepare
        ("
            INSERT INTO products 
            (name, description, type, price, stock, is_available, is_active_ img)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "sssdiiis",
            $name,
            $description,
            $type,
            $price,
            $stock,
            $isAvailable,
            $isActive,
            $img,
        );

    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}