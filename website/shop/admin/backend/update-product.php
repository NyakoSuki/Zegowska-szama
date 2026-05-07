<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);
$action = $_POST["addSwitchValue"] ?? "";

$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$type = $_POST["type"] ?? "";
$price = (float)($_POST["price"] ?? 0);
$stock = (int)($_POST["stock"]);
$isAvailable = isset($_POST["available"]) ? 1 : 0;
$isActive = isset($_POST["active"]) ? 1 : 0;
$img = $_POST["img"] ?? "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

// UPDATE PRODUCT
if ($action === "update")
{
    // GUARD CLAUSES
    if (empty($id) || empty($name) || empty($price)) exit("empty");


    // UPDATE WITH NULL STOCK
    if ($stock === "")
    {
        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name = ?, description = ?, type = ?, price = ?, stock = NULL, is_available = ?, is_active - ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "sssdiiss",
            $name,
            $description,
            $type,
            $price,
            $isAvailable,
            $isActive,
            $img,
            $id
        );
    }
    else
    {
        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name = ?, description = ?, type = ?, price = ?, stock = ?, is_available = ?, is_active = ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "sssdiiisi",
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
    }


    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}


if ($action === "add")
{
    // GUARD CLAUSES
    if (empty($name) || empty($price)) exit("empty");

    // UPDATE WITH NULL STOCK
    if ($stock === "")
    {
        $stmt = $connection->prepare
        ("
            INSERT INTO products 
            (name, description, type, price, stock, is_available, is_active, img)
            VALUES (?, ?, ?, ?, NULL, ?, ?, ?)
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "sssdiis",
            $name,
            $description,
            $type,
            $price,
            $isAvailable,
            $isActive,
            $img,
        );
    }
    else
    {
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
    }

    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}