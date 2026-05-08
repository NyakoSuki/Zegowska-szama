<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;

$_SESSION["theme"] = $_SESSION["theme"] === "dark" ? "light" : "dark";

header("Location: " . ACCOUNT_F_URL . "account.php");
exit;