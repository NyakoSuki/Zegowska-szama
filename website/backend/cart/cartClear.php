<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

// Clear all items from the cart stored in the session
$_SESSION["cart"] = [];

// Redirect back to the cart page after clearing
header("Location: " . PUBLIC_URL . "html/cart/cart.php");
exit;