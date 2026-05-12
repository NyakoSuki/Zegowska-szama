<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

    if ($_SESSION["role"] !== "admin") 
    {
        //header("Location: " . ACCOUNT_F_URL . "account.php");
        //exit;
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    //---HEADER---
    $site = basename($_SERVER['PHP_SELF']);
    $folder = basename(__DIR__);
    include PUBLIC_PATH . "html/shared/header.php";
    ?>