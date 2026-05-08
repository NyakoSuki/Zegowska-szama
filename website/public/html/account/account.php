<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;


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
                Konto
            </h1>
            <h4 class="text-center">
                Zalogowany jako: <?= htmlspecialchars($username) ?>
            </h4>
        </div>


        <div class="row justify-content-center g-4">
    <div class="col-10 col-md-8 col-lg-6">

        <div class="row g-3">

            <!-- Zmień nazwę -->
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#usernameModal">
                    Zmień nazwę
                </button>

                <?php
                if(isset($_SESSION["error"]))
                {
                    if($_SESSION["error"] == "used")
                        echo "<h6 class='text-danger mt-2'>Ta nazwa jest już zajęta</h6>";
                    if($_SESSION["error"] == "unone")
                        echo "<h6 class='text-success mt-2'>Pomyślnie zmieniono nazwę</h6>";
                }
                ?>
            </div>

            <!-- Hasło -->
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#passwordModal">
                    Zmiana hasła
                </button>

                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"])
                    {
                        case "short":
                            echo "<h6 class='text-danger mt-2'>Min. 8 znaków</h6>";
                            break;
                        case "notsame":
                            echo "<h6 class='text-danger mt-2'>Hasła nie są takie same</h6>";
                            break;
                        case "old":
                            echo "<h6 class='text-danger mt-2'>Nowe hasło nie może być takie samo</h6>";
                            break;
                        case "uncorrect":
                            echo "<h6 class='text-danger mt-2'>Złe aktualne hasło</h6>";
                            break;
                        case "pnone":
                            echo "<h6 class='text-success mt-2'>Hasło zmienione</h6>";
                            break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>
            </div>

            <!-- Zamówienia -->
            <div class="col-12 <?=$_SESSION['role'] == 'admin' ? 'col-md-6' : ''?>">
                <a href="<?=ACCOUNT_F_URL?>orders.php" class="btn btn-dark w-100">
                    Zamówienia
                </a>
            </div>

            <!-- Admin -->
            <div class="col-12 col-md-6 <?=$_SESSION['role'] == 'admin' ? '' : 'd-none'?>">
                <a
                    href="<?=ADMIN_F_URL?>admin.php"
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
        <form
            action="<?=ACCOUNT_B_URL?>theme.php"
            methode="post"
        >
            <button
                type="submit"
                class="btn btn-dark m-1"
            >
                Motyw: <?=$_SESSION["theme"] === "dark" ? "Jasny" : "Ciemy";?>
            </button>
        </form>
    </main>

    
    <?php include "popups.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=JS_URL?>theme.js"></script>
</body>
</html>