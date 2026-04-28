<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


// INPUT DATA
$id = (int)($_POST["id"] ?? 0);
$action = $_POST["action"] ?? "";


// UPDATE PRODUCT
if ($action === "update")
{
    $name = $_POST["name"] ?? "";
    $description = $_POST["description"] ?? "";
    $price = (float)($_POST["price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? -1);
    $is_available = isset($_POST["is_available"]) ? 1 : 0;
    $img = $_POST["img"] ?? "";


    // GUARD CLAUSES
    if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
    if (empty($id) || empty($name) || empty($price)) exit;


    // UPDATE WITH NULL STOCK
    if ($stock === -1)
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
if ($action === "delete")
{
    $stmt = $connection->prepare
    ("
        DELETE FROM products 
        WHERE id = ?
    ");
        if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param("i", $id);
        if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}