<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;

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
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    //---HEADER---
    $_SESSION["site"] = "account";
    include HEADER_PATH;
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
                    <button type="button" class="btn btn-dark w-100 m-1" data-bs-toggle="modal" data-bs-target="#userModal">
                        Zarządzanie Urzytkownikami
                    </button>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-dark w-100 m-1" data-bs-toggle="modal" data-bs-target="#orderModal">
                        Zarządzanie Zamówieniami
                    </button>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-dark w-100 m-1" data-bs-toggle="modal" data-bs-target="#productModal">
                        Zarządzanie Produkami
                    </button>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-dark w-100 m-1" data-bs-toggle="modal" data-bs-target="#discountModal">
                        Zarządzanie Promocjami
                    </button>
                </div>

            </div>
        </div>
    </main>



dodawanie prod
usuwanie/edycja prod

dodawanie disc
usuwanie/edycja disc

obsluga order



    <?php include "popups.php"?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=JS_URL?>admin.js"></script>
</body>
</html>