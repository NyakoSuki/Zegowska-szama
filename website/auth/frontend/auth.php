<?php

session_start();

require_once dirname(__DIR__, 2) . "/config.php";

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie/Rejestracja - Zegowska szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>auth.css">
</head>

<body>

<main class="container-fluid">

<?php
$signupErrors = ["exists","short","none"];
$active = (!empty($_SESSION['error']) && in_array($_SESSION['error'], $signupErrors))
    ? "signup-active"
    : "";
?>

<div class="container-box <?= $active ?>">

    <!-- PRZYCISKI PRZEŁĄCZANIA -->
    <div class="switcher">
        <button id="loginBtn" type="button">Login</button>
        <button id="signupBtn" type="button">Sign Up</button>
    </div>

    <div class="slider" id="slider">

        <!-- LOGIN -->
        <div class="panel login">
            <h1><b>LOGIN</b></h1>

            <form action="<?=AUTH_B_URL?>login.php" method="post">

                <label>Email:<br>
                    <input name="email" type="email">
                </label>

                <label>Password:<br>
                    <input name="password" type="password">
                </label>

                <!-- ERROR LOGIN -->
                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"]) 
                    {
                        case "uncorrect" : echo "<h4 class='error'>Niepoprawne dane</h4>"; break;
                        case "locked" : echo "<h4 class='error'>Zbyt wiele nieudanych prób. Sprubuj ponownie za 5 minut</h4>"; break;
                    }
                }
                ?>

                <div class="buttons">
                    <button type="submit">Login</button>
                    <button type="reset">Reset</button>
                </div>

            </form>
        </div>

        <!-- SIGN UP -->
        <div class="panel signup">
            <h1><b>SIGN UP</b></h1>

            <form action="<?=AUTH_B_URL?>signup.php" method="post">

                <label>Username:<br>
                    <input name="username" type="text">
                </label>

                <label>Email:<br>
                    <input name="email" type="email">
                </label>

                <label>Password:<br>
                    <input name="password" type="password">
                </label>

                <!-- ERROR SIGNUP -->
                <?php
                if(isset($_SESSION["error"]))
                {
                    switch ($_SESSION["error"]) 
                    {
                        case "exists" : echo "<h4 class='error'>Użytkownik już istnieje</h4>"; break;
                        case "short" : echo "<h4 class='error'>Hasło jest zbyt krótkie</h4>"; break;
                        case "none" : echo "<h4 class='success'>Pomyślnie zarejestrowano</h4>"; break;
                    }
                    unset($_SESSION["error"]);
                }
                ?>

                <div class="buttons">
                    <button type="submit">Sign up</button>
                    <button type="reset">Reset</button>
                </div>

            </form>
        </div>

    </div>
</div>

</main>

<script src="<?=JS_URL?>auth-animation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>