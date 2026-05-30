<?php
session_start();
require_once dirname(__DIR__, 3) . "/backend/config/config.php";
require_once BACKEND_PATH . "shared/siteblocker.php";
include BACKEND_PATH . "database/database.php";


// GET USER DATA
$id = $_SESSION["id"];

$stmt = $connection->prepare
("
    SELECT username 
    FROM users 
    WHERE id = ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("i", $id);
    if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$username = $row["username"];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto - Zegowska Szama</title>

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
        <div class="text-center mb-3">
            <h1 class="fw-bold text-center">
                Konto
            </h1>
            <h4 class="text-center">
                Zalogowany jako: <?= htmlspecialchars($username) ?>
            </h4>
        </div>


    <div class="row justify-content-center g-4">
    <div class="col-10 col-md-8 col-lg-6">

        <div class="row g-3">
            <div
                class="col-12 d-flex justify-content-center"
            >
                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"])
                    {
                        case "used":
                            echo "<h4 class='text-danger mt-2'>Ta nazwa jest już zajęta</h4>";
                            break;

                        case "unone":
                            echo "<h4 class='text-success mt-2'>Pomyślnie zmieniono nazwę</h4>";
                            break;

                        case "short":
                            echo "<h4 class='text-danger mt-2'>Min. 8 znaków</h4>";
                            break;

                        case "notsame":
                            echo "<h4 class='text-danger mt-2'>Hasła nie są takie same</h4>";
                            break;

                        case "old":
                            echo "<h4 class='text-danger mt-2'>Nowe hasło nie może być takie samo</h4>";
                            break;

                        case "uncorrect":
                            echo "<h4 class='text-danger mt-2'>Złe aktualne hasło</h4>";
                            break;

                        case "pnone":
                            echo "<h4 class='text-success mt-2'>Hasło zmienione</h4>";
                            break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>
                </div>
            <!-- Zmień nazwę -->
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#usernameModal">
                    Zmień nazwę
                </button>
            </div>

            <!-- Hasło -->
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#passwordModal">
                    Zmiana hasła
                </button>
            </div>

            <!-- Zamówienia -->
            <div class="col-12 <?=$_SESSION['role'] == 'admin' ? 'col-md-6' : ''?>">
                <a href="<?=PUBLIC_URL?>html/account/orders.php" class="btn btn-dark w-100">
                    Zamówienia
                </a>
            </div>

            <!-- Admin -->
            <div class="col-12 col-md-6 <?=$_SESSION['role'] == 'admin' ? '' : 'd-none'?>">
                <a
                    href="<?=PUBLIC_URL?>html/admin/admin.php"
                    class="btn btn-info w-100">
                    Admin panel
                </a>
            </div>

            <!-- LOGOUT (zawsze osobno) -->
            <div class="col-12">
                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Wyloguj się
                </button>
            </div>

        </div>

    </div>
</div>
               

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include "popups.php"?>
    <script src="<?=PUBLIC_URL?>js/account/theme.js"></script>
    <script src="<?=PUBLIC_URL?>js/shared/showPassword.js"></script>
    <script src="<?=PUBLIC_URL?>js/shared/theme.js"></script>
    
</body>
</html>