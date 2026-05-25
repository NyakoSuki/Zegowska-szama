<?php
session_start();
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";


if (!isset($_SESSION["cart"]))
{
    $_SESSION["cart"] = [];
}
$id = (int)($_POST["id"] ?? '');
$name = $_POST["name"] ?? '';
$quantity = (int)($_POST["quantity"] ?? '');
$left = (int)($_POST["left"] ?? 1);

if(empty($id))
{
    http_response_code(404);
    echo json_encode
    ([
        "success" => false,
        "message" => "Produkt nie istnieje"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
if($quantity < 1)
{
    http_response_code(409);
    echo json_encode
    ([
        "success" => false,
        "message" => "Nie możesz dodawać ilości mniejszych niż 1"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
if(($_SESSION["cart"][$id] ?? 0) + $quantity > 10)
{
    http_response_code(409);
    echo json_encode
    ([
        "success" => false,
        "message" => 'Nie możesz mieć więcej niż 10 takich samych produktów w koszyku naraz! Posiadasz: ' . ($_SESSION['cart'][$id] ?? 0)
    ], JSON_UNESCAPED_UNICODE);
    exit;

}
if(($_SESSION["cart"][$id] ?? 0) + $quantity > $left && $left !== -1)
{
    http_response_code(409);
    echo json_encode
    ([
        "success" => false,
        "message" => "Przepraszamy ale ten produkt nie jest dostępny w większej ilości"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
$_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + $quantity;
    http_response_code(200);
    echo json_encode
    ([
        "success" => true,
        "message" => 'Pomyślnie dodano "' . $name . '" w ilości: ' . $quantity
    ], JSON_UNESCAPED_UNICODE);
    exit;