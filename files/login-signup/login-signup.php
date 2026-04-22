<?php

session_start();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie/Rejestracja - Zegowska Szama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container-fluid">
        <?php $active = !empty($_SESSION['userExists']) ? "signup-active" : ""; ?>
        <div class="container-box <?= $active ?>">

            <!-- PRZYCISKI PRZEŁĄCZANIA -->
            <div class="switcher">
                <button id="signinBtn" type="button">Login</button>
                <button id="signupBtn" type="button">Sign Up</button>
            </div>

            <!-- SLIDER -->
            <div class="slider" id="slider">

                <!-- LOGIN -->
                <div class="panel login">
                    <h1><b>LOGIN</b></h1>

                    <form action="login.php" method="post">
                        <label>Email:<br>
                            <input name="emailLogin" type="text" required>
                        </label>

                        <label>Password:<br>
                            <input name="passwordLogin" type="password" required>
                        </label>

                        <!-- WYŚWIETLANIE POWIADOMIENIA O BŁĘDNYM WPROWADZENIU DANYCH -->
                        <?php
                            if(isset($_SESSION['correctData']) && $_SESSION['correctData'] === false){
                                echo "<p>Niepoprawny login lub hasło!</p>";
                                unset($_SESSION['correctData']);
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

                    <form action="signup.php" method="post">
                        <label>Username:<br>
                            <input name="usernameSignup" type="text" required>
                        </label>

                        <label>Email:<br>
                            <input name="emailSignup" type="text" required>
                        </label>

                        <label>Password:<br>
                            <input name="passwordSignup" type="password" required>
                        </label>

                        <!-- WYŚWIETLANIE POWIADOMIENIA GDY UŻYTKOWNIK JUŻ ISTNIEJE -->
                        <?php
                            if(isset($_SESSION['userExists']) && $_SESSION['userExists'] === true){
                                echo "<p>Użytkownik już istnieje!</p>";
                                unset($_SESSION['userExists']);
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

    
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>