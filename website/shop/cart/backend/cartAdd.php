<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";


if (!isset($_SESSION["cart"]))
{
    $_SESSION["cart"] = [];
}
$id = $_POST["id"] ?? '';
$quantity = $_POST["quantity"] ?? '';

if(empty($id)) exit("Nieznaleziono id produktu");

$_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + $quantity;