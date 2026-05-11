<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";

$cart = $_SESSION["cart"] ?? [];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/main.css">
</head>

<body class="<?=$_SESSION['theme']?>">
    <?php
    $site = "cart";
    include PUBLIC_PATH . "html/shared/header.php";
    ?>
    <main>
        <section class="p-3 mb-3">

            <div class="row g-2 d-flex justify-content-center">

                <div class="col-12 col-md-6 col-lg-3">
                    <button
                        id="cartOrderBtn"
                        type="button"
                        class="btn btn-success w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#orderModal"
                    >
                        Zamów
                    </button>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <button
                        type="button"
                        class="btn btn-danger w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#clearModal"
                    >
                        Wyczyść koszyk
                    </button>
                </div>

            </div>

            <div class="mt-3 col-12">
                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"])
                    {
                        case "" :
                            echo "<h4 class='text-danger mb-0'>Przepraszamy, ale" . $_SESSION["error"] . " nie jest już dostępny</h4>";
                            break;

                        case "none" :
                            echo "<h4 class='text-success mb-0'>Pomyślnie złożono zamówienie</h4>";
                            break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>
            </div>

        </section>

        <!--
        * ====================PRODUCTS====================
         * generated in productCreate.php
        * ==================================================
        -->
        <?php include BACKEND_PATH . "shared/productCreate.php"?>

        
    </main>


    <?php include "popup.php"?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include BACKEND_PATH . "config/config.js.php"?>
    <script src="<?= PUBLIC_URL ?>js/cart/cartUpdate.js"></script>
</body>
</html>