<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $price = (float)($_POST["price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? -1);
    $is_available = isset($_POST["is_available"]) ? 1 : 0;
    $img = $_POST["img"] ?? '';

   if(empty($name) || empty($price)) exit;

    if ($stock === -1) 
    {
        $stmt = $connection->prepare
        ("
        INSERT INTO products (name, description, price, stock, is_available, img)
        VALUES (?, ?, ?, null, ?, ?)
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

    if (!$stmt->execute()) exit("SQL execute error");

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;