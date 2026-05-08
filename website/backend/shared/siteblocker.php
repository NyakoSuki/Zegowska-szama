<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";

if (!isset($_SESSION["id"])) 
{
    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}