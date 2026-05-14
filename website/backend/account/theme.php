<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

$_SESSION["theme"] = $_SESSION["theme"] === "dark" ? "light" : "dark";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
exit;