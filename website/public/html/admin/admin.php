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
    include PUBLIC_PATH . "html/shared/header.php";
    ?>

    <main class="container p-3">

        <div class="text-center mb-5">
            <h1 class="fw-bold text-center">
                Admin panel
            </h1>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-10 col-md-6 col-lg-4 col-xl-3">

                <div class="mb-3">
                    <a href="user.php" class="btn btn-dark w-100 m-1">
                        Zarządzanie Urzytkownikami
                    </a>
                </div>

                <div class="mb-3">
                    <a href="order.php" class="btn btn-dark w-100 m-1">
                        Zarządzanie Zamówieniami
                    </a>
                </div>

                <div class="mb-3">
                    <a href="product.php" class="btn btn-dark w-100 m-1">
                        Zarządzanie Produkami
                    </a>
                </div>

                <div class="mb-3">
                    <a href="discount.php" class="btn btn-dark w-100 m-1">
                        Zarządzanie Promocjami
                    </a>
                </div>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>