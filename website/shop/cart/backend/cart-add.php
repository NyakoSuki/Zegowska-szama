<?php

session_start();
require_once dirname(__DIR__, 3) . "/config.php";

if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = [];
}

if (isset($_POST['id']))
{
    $id = (int)$_POST['id'];

    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

header("Location: " . HOME_F_URL . "home.php");
exit;