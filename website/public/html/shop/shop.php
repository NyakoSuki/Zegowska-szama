<?php
session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama - sklep</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    $site = basename($_SERVER['PHP_SELF']);
    include PUBLIC_PATH . "html/shared/header.php";
    ?>
    <main>
        <!--
        < ====================PRODUCT LIST====================
         -> gets generated in productGenerate.php
        < ==================================================
        -->
            <?php include BACKEND_PATH . "shared/productGenerate.php"?>

            
        <!--
        < ====================FILTER====================
         -> allows to filter products by:
            > types
            > name
            > price
        < ==================================================
        -->
            <?php include "filter.php"?>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include BACKEND_PATH . "config/config.js.php"?>
    <?php include "popup.php"?>
    <?php include PUBLIC_PATH . "html/shared/popup.php"?>
    <script src="<?=PUBLIC_URL?>js/shop/cartAdd.js"></script>
    <script src="<?=PUBLIC_URL?>js/shop/shopFilter.js"></script>
</body>
</html>