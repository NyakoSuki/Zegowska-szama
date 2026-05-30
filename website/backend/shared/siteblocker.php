<?php
require_once dirname(__DIR__, 2) . "/backend/config/config.php";

// Block access to this file if the user is not logged in
if (!isset($_SESSION["id"])) 
{
    header("Location: " . PUBLIC_URL . "html/auth/auth.php");
    exit;
}