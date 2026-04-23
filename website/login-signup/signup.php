<?php

session_start();

include "../data-base.php";

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

                $stmt = $connection->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                //SPRAWDZANIE CZY USERNAME LUB EMAIL SĄ ZAJĘTE
                if($result->num_rows > 0)
                    {
                        $_SESSION['userExists'] = true;
                        header("Location: login-signup.php");
                        exit;
                    }
                else
                    {
                        //JEŻELI USERNAME LUB EMAIL NIE SĄ ZAJĘTE -> REJESTRACJA
                        $stmt = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $email, $password);
                        if($stmt->execute())
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