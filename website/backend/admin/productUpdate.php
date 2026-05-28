<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$id = (int)($_POST["idInp"] ?? 0);

$name = $_POST["nameInp"] ?? "";
$description = $_POST["descriptionInp"] ?? "";
$type = $_POST["typeSel"] ?? "";
$price = (float)($_POST["priceInp"] ?? 0);
$stock = (int)($_POST["stockInp"]);
$isAvailable = isset($_POST["availableInp"]) ? 1 : 0;
$isActive = isset($_POST["activeInp"]) ? 1 : 0;
$img = $_POST["imgInp"] ?? "";

$action = $_POST["actionBtn"] ?? '';

if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    http_response_code(400);
    echo json_encode
    ([
        "success" => false,
        "message" => "SQL error"
    ]);
    exit;
}
if(empty($name) || empty($price))
{
    http_response_code(400);
    echo json_encode
    ([
        "success" => false,
        "message" => "SQL error"
    ]);
    exit;
}

// UPDATE PRODUCT
if ($action === "update")
{
    // GUARD CLAUSES
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode
        ([
            "success" => false,
            "message" => "SQL error"
        ]);
        exit;
    }


        $stmt = $connection->prepare
        ("
            UPDATE products 
            SET name = ?, description = ?, type = ?, price = ?, stock = ?, is_available = ?, is_active = ?, img = ?
            WHERE id = ?
        ");
            if (!$stmt)
            {
                http_response_code(400);
                echo json_encode
                ([
                    "success" => false,
                    "message" => "SQL error"
                ]);
                exit;
            }

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



    // EXECUTE UPDATE
    if (!$stmt->execute())
    {
        http_response_code(400);
        echo json_encode
        ([
            "success" => false,
            "message" => "SQL error"
        ]);
        exit;
    }

    header('Content-Type: application/json');

    http_response_code(400);
    echo json_encode
    ([
        "success" => false,
        "message" => "SQL error"
    ]);
    exit;


if ($action === "add")
{
    // GUARD CLAUSES

    // UPDATE WITH NULL STOCK
   
        $stmt = $connection->prepare
        ("
            INSERT INTO products 
            (name, description, type, price, stock, is_available, is_active, img)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
            if (!$stmt)
            {
                http_response_code(400);
                echo json_encode
                ([
                    "success" => false,
                    "message" => "SQL error"
                ]);
                exit;
            }

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
            $img
        );

    // EXECUTE UPDATE
        if (!$stmt->execute())
        {
            http_response_code(400);
            echo json_encode
            ([
                "success" => false,
                "message" => "SQL error"
            ]);
            exit;
        }

    header('Content-Type: application/json');

    echo json_encode
    ([
        "success" => true,
        "message" => "Pomyślnie dodano nowy produkt"
    ]);
    exit;
}}