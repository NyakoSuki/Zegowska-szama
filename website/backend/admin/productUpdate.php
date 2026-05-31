<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

$id          = (int)($_POST["idInp"] ?? 0);
$name        = $_POST["nameInp"] ?? "";
$description = $_POST["descriptionInp"] ?? "";
$type        = $_POST["typeSel"] ?? "";
$price       = (float)($_POST["priceInp"] ?? 0);
$stock       = (int)($_POST["stockInp"] ?? 0);
$isAvailable = isset($_POST["availableInp"]) ? 1 : 0;
$isActive    = isset($_POST["activeInp"]) ? 1 : 0;
$img         = $_POST["imgInp"] ?? "";
$action      = $_POST["actionBtn"] ?? "";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Nieprawidłowa metoda"]);
    exit;
}

if (empty($name) || empty($price))
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Nazwa i cena są wymagane"]);
    exit;
}


// UPDATE PRODUCT
if ($action === "update")
{
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Brak ID produktu"]);
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
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL prepare error"]);
        exit;
    }

    $stmt->bind_param("sssdiiisi", $name, $description, $type, $price, $stock, $isAvailable, $isActive, $img, $id);

    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL execute error"]);
        exit;
    }

    echo json_encode(["success" => true, "message" => "Pomyślnie zaktualizowano produkt"]);
    exit;
}


// ADD PRODUCT
if ($action === "add")
{
    $stmt = $connection->prepare
    ("
        INSERT INTO products (name, description, type, price, stock, is_available, is_active, img)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt)
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL prepare error"]);
        exit;
    }

    $stmt->bind_param("sssdiiis", $name, $description, $type, $price, $stock, $isAvailable, $isActive, $img);

    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL execute error"]);
        exit;
    }

    echo json_encode(["success" => true, "message" => "Pomyślnie dodano nowy produkt"]);
    exit;
}

http_response_code(400);
echo json_encode(["success" => false, "message" => "Nieznana akcja"]);