<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;

$id = (int)($_POST["id"] ?? 0);

if($_POST["action"] === 'update')
{
    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $price = (float)($_POST["price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? -1);
    $is_available = isset($_POST["is_available"]) ? 1 : 0;
    $img = $_POST["img"] ?? '';

    if(empty($id) || empty($name) || empty($price)) exit;

    if ($stock === -1) 
        {
        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name=?, description=?, price=?, stock=NULL, is_available=?, img=?
            WHERE id=?
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
            SET name=?, description=?, price=?, stock=?, is_available=?, img=?
            WHERE id=?
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

    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ACCOUNT_F_URL . "admin.php");
    exit;
}

if($_POST["action"] === 'delete')
{
    $stmt = $connection->prepare("DELETE FROM products where id = ?");

    if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ACCOUNT_F_URL . "admin.php");
    exit;
}