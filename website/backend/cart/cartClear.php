<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";


$_SESSION["cart"] = [];

header("Location: " . PUBLIC_URL . "html/cart/cart.php");
exit;