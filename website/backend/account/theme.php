<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

$_SESSION["theme"] = $_SESSION["theme"] === "dark" ? "light" : "dark";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
exit;