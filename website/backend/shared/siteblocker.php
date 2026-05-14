<?php
require_once dirname(__DIR__, 2) . "/backend/config/config.php";

if (!isset($_SESSION["id"])) 
{
    header("Location: " . PUBLIC_URL . "html/auth/auth.php");
    exit;
}