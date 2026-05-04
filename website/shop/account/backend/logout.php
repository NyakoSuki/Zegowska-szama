<?php
session_start();
require_once dirname(__DIR__, 3) . "/config.php";

$theme = $_SESSION["theme"];

$_SESSION = [];
session_unset();

session_start();
$_SESSION["theme"] = $theme;

header("Location: " . AUTH_F_URL . "auth.php");
exit;