<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;

$_SESSION["site"] = "account";
include HEADER_PATH;

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


<body>
     


    <main class="container p-3">

        <!-- HEADER -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-center">
                Konto
            </h1>
            <h4 class="text-center">
                Zalogowany jako: <?= htmlspecialchars($username) ?>
            </h4>
        </div>


        <div class="row justify-content-center g-4">

            <!-- USERNAME -->
            <div class="col-12 col-lg-5">
                <div class="username card bg-light border-dark">

                    <div class="card-body">

                        <h5 class="card-title mb-3">
                            Zmiana nazwy użytkownika
                        </h5>

                        <form action="<?=ACCOUNT_B_URL?>change-username.php" method="post"
                            class="d-grid gap-2">


                            <?php
                            if(isset($_SESSION["error"]))
                            {
                                switch ($_SESSION["error"])
                                {
                                    case "used":
                                        echo "<h6 class='text-danger mt-2'>Ta nazwa jest już zajęta</h6>";
                                        break;

                                    case "unone":
                                        echo "<h6 class='text-success mt-2'>Pomyślnie zmieniono nazwę</h6>";
                                        break;
                                }
                            }
                            ?>

                        <button type="button" class="btn btn-success flex-fill col-lg-3 col-md-6 col-12 m-1" data-bs-toggle="modal" data-bs-target="#orderModal">
                            Zmień nazwę
                        </button>

                        </form>

                    </div>

                </div>
            </div>


            <!-- PASSWORD -->
            <div class="col-12 col-lg-5">
                <div class="password card bg-light border-dark">
                    <div class="card-body">

                        <h5 class="card-title mb-3">
                            Zmiana hasła
                        </h5>

                        <form action="<?=ACCOUNT_B_URL?>change-password.php" method="post" class="d-grid gap-2">

                            <input
                                type="password"
                                name="current"
                                class="form-control bg-light border-dark"
                                placeholder="Obecne hasło"
                                require
                            >

                            <input
                                type="password" 
                                name="new"
                                class="form-control bg-light border-dark"
                                placeholder="Nowe hasło"
                                require
                            >

                            <input
                                type="password"
                                name="confirm"
                                class="form-control bg-light border-dark"
                                placeholder="Powtórz nowe hasło"
                                require
                            >
                            
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

                            <button
                                class="btn btn-dark col-8 offset-2">
                                Zmień hasło
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>


            <!-- ACTIONS -->
        <div class="col-12 col-lg-6 offset-lg-3 mt-5">
            <div class="actions card bg-light border-dark">
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">

                        <a
                            href="<?=ADMIN_F_URL?>admin.php"
                            class="btn btn-info w-100 w-sm-auto
                            <?=$_SESSION['role'] == 'admin' ? '' : 'd-none'?>">
                            Admin panel
                        </a>

                        <form action="<?=ACCOUNT_F_URL?>orders.php" method="post" class="w-100 w-sm-auto">
                            <button
                                class="btn btn-dark w-100">
                                Zamówienia
                            </button>
                        </form>

                        <form action="<?=ACCOUNT_B_URL?>logout.php" method="post" class="w-100 w-sm-auto">
                            <button 
                                class="btn btn-danger w-100">
                                Wyloguj się
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        </div>
    </main>

    
    <?php include "popups.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>