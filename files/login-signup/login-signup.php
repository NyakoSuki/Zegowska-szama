<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Zegowska Szama</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <main class="container-fluid">
        <img class="img-fluid" src="../../images/zegowska_szama_logo.png" alt="logo">
        <div class="col-12 vh-100 d-flex flex-column flex-md-row justify-content-center align-items-center">
            <span class="in">
                <h3><b>LOGIN</b></h3>
                <label for="username">Username:<input id="usernamelgin" type="text"></label><br><br>
                <label for="password">password:<input id="passwordlgin" type="password"></label><br><br>
                <button class="btn btn-primary" type="submit">Login</button>
                <button class="btn btn-danger" type="reset">reset</button>
            </span>
            <span class="up">
                <h3><b>SIGN UP</b></h3>
                    <form action="signup.php" method="post">
                        <label for="usernameSignup">Username:<input id="usernameSignup" name="usernameSignup" type="text" require></label><br><br>
                        <label for="emailSignup">Email:<input id="emailSignup" name="emailSignup" type="text" require></label><br><br>
                        <label for="passwordSignup">password:<input id="passwordSignup" name="passwordSignup" type="password" require></label><br><br>
                        <button class="btn btn-primary" type="submit">Sign up</button>
                        <button class="btn btn-danger"  type="reset">reset</button>
                    </form>
            </span>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>