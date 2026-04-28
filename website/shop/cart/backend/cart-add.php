<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";


$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = [];
}

if (isset($_POST['id']))
{
    $id = (int)$_POST['id'];

    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

if($_POST["add"] === "home")
{
    header("Location: " . HOME_F_URL . "home.php");
    exit;
}
if($_POST["add"] === "cart")
{    
    header("Location: " . CART_F_URL . "cart.php");
    exit;
}