<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id)
{

    if (!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

header("Location: " . CART_F_URL . "cart.php");
exit;