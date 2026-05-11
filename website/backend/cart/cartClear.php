<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";


$_SESSION["cart"] = [];

header("Location: " . PUBLIC_PATH . "html/cart/cart.php");
exit;