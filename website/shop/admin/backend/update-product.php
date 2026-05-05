<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);
$action = $_POST["addSwitchValue"] ?? "";

$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$price = (float)($_POST["price"] ?? 0);
$stock = $_POST["stock"];
$is_available = isset($_POST["available"]) ? 1 : 0;
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
            SET name = ?, description = ?, price = ?, stock = NULL, is_available = ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "ssdiss",
            $name,
            $description,
            $price,
            $is_available,
            $img,
            $id
        );
    }
    else
    {
        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name = ?, description = ?, price = ?, stock = ?, is_available = ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "ssdiisi",
            $name,
            $description,
            $price,
            $stock,
            $is_available,
            $img,
            $id
        );
    }


    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}


// DELETE PRODUCT
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
            (name, description, price, stock, is_available, img)
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
            $img,
        );
    }
    else
    {
        $stmt = $connection->prepare
        ("
            INSERT INTO products 
            (name, description, price, stock, is_available, img)
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
            $img,
        );
    }

    // EXECUTE UPDATE
    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}