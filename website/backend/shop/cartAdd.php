<?php
session_start();

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
    exit("Produkt nie istnieje");
}
if($quantity < 1)
{
    http_response_code(409);
    exit("Nie możesz dodawać ilości mniejszych niż 1");
}
if(($_SESSION["cart"][$id] ?? 0) + $quantity > 10)
{
    http_response_code(409);
    exit("Nie możesz mieć więcej niż 10 takich samych produktów w koszyku naraz! Posiadasz: " . ($_SESSION['cart'][$id] ?? 0));

}
if(($_SESSION["cart"][$id] ?? 0) + $quantity > $left && $left !== -1)
{
    http_response_code(409);
    exit("Przepraszamy ale ten produkt nie jest dostępny w większej ilości");
}
$_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + $quantity;
exit("Pomyślnie dodano \"" . $name . "\"\n w ilości: " . $quantity);