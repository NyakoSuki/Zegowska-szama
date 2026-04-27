<?php

require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;

include DB_PATH;


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto - Zegowska szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=CSS_URL?>account.css">
</head>

<body>
    <header class="container-fluid sticky-top p-3">
        <div class="top row align-items-center">

            <!-- LOGO -->
            <div class="col-md-8 col-sm-7">
                <a href="<?=HOME_F_URL?>home.php" class="d-inline-block">
                    <img src="<?=IMG_URL?>logo.png" class="img-fluid logo-img" alt="logo">
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-md-4 col-sm-5 col-7 text-end">
                <a href="<?=ACCOUNT_F_URL?>account.php" class="btn btn-outline-light btn-sm">Account</a>
                <a href="<?=CART_F_URL?>cart.php" class="btn btn-outline-light btn-sm">Cart</a>
                <a href="<?=HOME_F_URL?>home.php" class="btn btn-outline-light btn-sm">Home</a>
            </div>

        </div>
    </header>
<main class="container p-3>

    <?php
    
    $id = $_SESSION["id"];

    $stmt = $connection->prepare("SELECT username FROM users WHERE id = ?");

    if(!$stmt) die("SQL error: " . $connection->error);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    $username = $row["username"];
    
    ?>

    <!-- NAGŁÓWEK -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-center">Konto</h1>
        <h4 class="text-center">Zalogowany jako: <?= htmlspecialchars($username) ?></h4>
    </div>

    <div class="row justify-content-center g-4">

        <!-- ZMIANA NAZWY -->
        <div class="col-12 col-md-6 col-lg-5">

            <div class="username">
                <div class="">

                    <h5 class="card-title mb-3">Zmiana nazwy użytkownika</h5>

                    <form action="<?=ACCOUNT_B_URL?>change-username.php" method="post" class="d-grid gap-2">

                        <input type="text" name="username" class="rounded-2 p-1" placeholder="Nowa nazwa">

                        <button class="rounded-2 p-1">
                            Zmień nazwę
                        </button>

                    </form>

                </div>
            </div>

        </div>


        <!-- ZMIANA HASŁA -->
        <div class="col-12 col-md-6 col-lg-5">

            <div class="password">
                <div class="">

                    <h5 class="card-title mb-3">Zmiana hasła</h5>

                    <form action="<?=ACCOUNT_B_URL?>change-password.php" method="post" class="d-grid gap-2">

                        <input type="password" name="current" class="rounded-2 p-1" placeholder="Obecne hasło">
                        <input type="password" name="new" class="rounded-2 p-1" placeholder="Nowe hasło">
                        <input type="password" name="confirm" class="rounded-2 p-1" placeholder="Powtórz nowe hasło">

                        <button class="rounded-2 p-1">
                            Zmień hasło
                        </button>

                    </form>

                </div>
            </div>

        </div>


        <!-- PRZYCISKI -->
        <div class="col-12 col-md-10 col-lg-8">

            <div class="">
                <div class="d-flex flex-wrap gap-2 justify-content-center">

                        <a href="<?=ACCOUNT_F_URL?>admin.php" class="rounded-2 p-2 orders">Admin panel</a>

                    <form action="<?=ACCOUNT_F_URL?>orders.php" method="post">
                        <button class="rounded-2 p-2 orders">Zamówienia</button>
                    </form>

                    <form action="<?=ACCOUNT_B_URL?>logout.php" method="post">
                        <button class="rounded-2 p-2 logout">Wyloguj się</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</main>

</body>
</html>