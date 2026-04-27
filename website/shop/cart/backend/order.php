<?php

require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;

include DB_PATH;


$userId = $_SESSION["id"];
$totalPrice = 


$stmt = $connection->prepare
        ("
        INSERT INTO orders (user_id = ?, total_price = ?)
        VALUES (?, ?)
        ");

        if (!$stmt) exit("SQL prepare error");

        $stmt->bind_param
        (
            "sd",
            $userId,
            $
        );

    if (!$stmt->execute()) exit("SQL execute error");

while()
{
    $stmt = $connection->prepare
    ("
    INSERT INTO ordered_products (user_id = ?, product_id = ?, quantity = ?)
    VALUES (?, ?, ?)
    ");

    if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param
    (
        "ssi",
        $userId,
        $,
        $
    );

    if (!$stmt->execute()) exit("SQL execute error");
}



    header("Location: " . CART_F_URL . "cart.php");
    exit;