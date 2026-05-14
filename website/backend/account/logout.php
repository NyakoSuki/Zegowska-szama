<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

$theme = $_SESSION["theme"];

$_SESSION = [];
session_unset();

session_start();
$_SESSION["theme"] = $theme;

header("Location: " . PUBLIC_URL . "html/auth/auth.php");
exit;