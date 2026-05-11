<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";

$theme = $_SESSION["theme"];

$_SESSION = [];
session_unset();

session_start();
$_SESSION["theme"] = $theme;

header("Location: " . PUBLIC_PATH . "html/auth/auth.php");
exit;