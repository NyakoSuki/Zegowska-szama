<?php

session_start();

include "data_base.php";

//SPARWDZANIE METODY WYSŁANIA DANYCH
if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        //SPRAWDZANIE CZY NAZWA, EMAIL I HASŁO ZOSTAŁY WPISANE
        if (isset($_POST["usernameSignup"], $_POST["emailSignup"], $_POST["passwordSignup"]))
            {
                //PREPERED STATEMENT -> ZABEZPIECZA PRZED SQL INJECTION
                $username = $connection->real_escape_string($_POST["usernameSignup"]);
                $email = $connection->real_escape_string($_POST["emailSignup"]);
                $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);

                $numberOfRows = $connection->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
                //SPRAWDZANIE CZY USERNAME LUB EMAIL SĄ ZAJĘTE
                if($numberOfRows->num_rows > 0)
                    {
                        $_SESSION['userExists'] = true;
                        header("Location: login-signup.php");
                        exit;
                    }
                else
                    {
                        //JEŻELI USERNAME LUB EMAIL NIE SĄ ZAJĘTE -> REJESTRACJA
                        $signup = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                        $signup->bind_param("sss", $username, $email, $password);
                        if($signup->execute())
                            {
                                echo "Rejestracja zakończona sukcesem";
                            }
                        else
                            {
                                echo "Wystąpił błąd: ". $connection -> error;
                            }
                    }
            }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>