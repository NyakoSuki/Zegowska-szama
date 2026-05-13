<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";

if(!isset($_SESSION["theme"])) $_SESSION["theme"] = "light";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie/Rejestracja - Zegowska szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/auth.css">
</head>

<body class="d-flex align-items-center justify-content-center vh-100 <?=$_SESSION['theme']?>">
    <main class="container-fluid">

    <?php
    $signupErrors = ["exists","short","none"];
    $active = (!empty($_SESSION['error']) && in_array($_SESSION['error'], $signupErrors))
        ? "signup-active" : "";
    ?>

        <div class="container-box <?= $active ?>">

            <!-- PRZYCISKI PRZEŁĄCZANIA -->
            <div class="switcher">
                <button
                    id="loginBtn"
                    type="button"
                    class="btn btn-info">
                    Logowanie
                </button>
                <button
                    id="signupBtn"
                    type="button"
                    class="btn btn-info">
                    Rejestracja
                </button>
            </div>

            <div class="slider" id="slider">

                <!-- LOGIN -->
                <div class="panel login card bg-white p-5 m-2">
                    <h1 class="m-0 mb-5 p-0"><b>Logowanie</b></h1>

                    <form action="<?=BACKEND_URL?>auth/login.php" method="post">

                        <label class="m-0">Email:<br></label>
                            <input
                                name="email"
                                type="email"
                                class="form-control bg-light mb-2"
                                placeholder="Email"
                            >

                        <label class="m-0">Hasło:</label>
                        <div class="input-group mb-2">
                            <input
                                id="loginPasswordInp"
                                name="password"
                                type="password"
                                class="form-control bg-light mb-2"
                                placeholder="Hasło"
                                
                            >
                            <button
                                id="loginPasswordBtn"
                                class="btn btn-light mb-2"
                                type="button"
                            >
                            Pokaż
                            </button>
                        </div>

                        <!-- ERROR LOGIN -->
                        <?php
                        if(isset($_SESSION["error"]))
                        {
                            switch ($_SESSION["error"]) 
                            {
                                case "unactive":
                                    echo "<h4 class='text-danger mt-2'>Konto jest nieaktywne</h4>";
                                    break;

                                case "uncorrect":
                                    echo "<h4 class='text-danger mt-2'>Niepoprawne dane</h4>";
                                    break;

                                case "locked":
                                    echo "<h4 class='text-danger mt-2'>Zbyt wiele nieudanych prób. Sprubuj ponownie za 5 minut</h4>";
                                    break;
                            }
                        }
                        ?>

                        <div class="buttons">
                            <button
                                type="submit"
                                class="btn btn-success">
                                Zaloguj
                            </button>

                            <button
                                type="reset"
                                class="btn btn-danger">
                                Wyczyść
                            </button>
                        </div>

                    </form>
                </div>

                <!-- SIGNUP -->
                <div class="panel signup card bg-white p-5 m-2">
                    <h1 class="m-0 mb-2 p-0"><b>Rejestracja</b></h1>

                    <form action="<?=BACKEND_URL?>auth/signup.php" method="post">

                        <label class="m-0">Nazwa:<br></label>
                            <input
                                name="username"
                                type="text"
                                class="form-control bg-light mb-2"
                                placeholder="Nazwa"
                            >

                        <label class="m-0">Email:<br></label>
                            <input
                                name="email"
                                type="email"
                                class="form-control bg-light mb-2"
                                placeholder="Email"
                            >

                        <label class="m-0">Hasło:</label><br>
                        <div class="input-group mb-2">
                            <input
                                id="signupPasswordInp"
                                name="password"
                                type="password"
                                class="form-control bg-light mb-2"
                                placeholder="Hasło"
                                
                            >
                            <button
                                id="signupPasswordBtn"
                                class="btn btn-light mb-2"
                                type="button"
                            >
                            Pokaż
                            </button>
                        </div>

                        <!-- ERROR SIGNUP -->
                        <?php
                        if(isset($_SESSION["error"]))
                        {
                            switch ($_SESSION["error"]) 
                            {
                                case "exists":
                                    echo "<h4 class='text-danger mt-2'>Użytkownik już istnieje</h4>";
                                    break;
                                    
                                case "short":
                                    echo "<h4 class='text-danger mt-2'>Hasło jest zbyt krótkie</h4>";
                                    break;

                                case "none":
                                    echo "<h4 class='text-success mt-2'>Pomyślnie zarejestrowano</h4>";
                                    break;
                            }
                            unset($_SESSION["error"]);
                        }
                        ?>

                        <div class="buttons">
                            <button
                                type="submit"
                                class="btn btn-success">
                                Zarejestruj
                            </button>

                            <button
                                type="reset"
                                class="btn btn-danger">
                                Wyczyść
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </main>


<script src="<?=PUBLIC_URL?>js/auth/animation.js"></script>
<script src="<?=PUBLIC_URL?>js/shared/showPassword.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>