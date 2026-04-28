<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";

$_SESSION["cart"] = [];

header("Location: " . CART_F_URL . "cart.php");
exit;