<?php

session_start();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie/Rejestracja - Zegowska Szama</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <main class="container-fluid">
        <img class="img-fluid" src="../../images/zegowska_szama_logo.png" alt="logo">
        <div class="col-12 vh-100 d-flex flex-column flex-md-row justify-content-center align-items-center">
            <span class="in">
                <h3><b>LOGIN</b></h3>
                <form action="login.php" method="post">
                    <label for="usernameLogin">Username:<input id="usernameLogin" name="usernameLogin" type="text" required></label>
                    <label for="passwordLogin">password:<input id="passwordLogin" name="passwordLogin" type="password" required></label>
                    <?php
                        if(isset($_SESSION['correctData']) && $_SESSION['correctData'] === false)
                            {
                                echo "<p>Niepoprawny login lub hasło!</p>";
                                unset($_SESSION['correctData']);
                            }
                    ?>
                    <div class="buttonsa">
                        <button type="submit">Login</button>
                        <button type="reset">reset</button>
                    </div>
                </form>
            </span>
            <span class="up">
                <h3><b>SIGN UP</b></h3>
                    <form action="signup.php" method="post">
                        <label for="usernameSignup">Username:<input id="usernameSignup" name="usernameSignup" type="text" required></label>
                        <label for="emailSignup">Email:<input id="emailSignup" name="emailSignup" type="text" required></label>
                        <label for="passwordSignup">password:<input id="passwordSignup" name="passwordSignup" type="password" required></label>
                         <?php
                            if(isset($_SESSION['userExists']) && $_SESSION['userExists'] === true)
                                {
                                    echo "<p>Użytkownik już istnieje!</p>";
                                    unset($_SESSION['userExists']);
                                }
                        ?>
                        <div class="buttonsb">
                            <button type="submit">Sign up</button>
                            <button  type="reset">reset</button>
                        </div>
                    </form>
            </span>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>