<?php

session_start();

include "data_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["usernameSignup"], $_POST["emailSignup"], $_POST["passwordSignup"]))
            {

                $username = $connection->real_escape_string($_POST["usernameSignup"]);
                $email = $connection->real_escape_string($_POST["emailSignup"]);
                $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);

                $numberOfRows = $connection->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
                if($numberOfRows->num_rows > 0)
                    {
                        $_SESSION['userExists'] = true;
                        header("Location: http://localhost/Zegowska-szama/files/login-signup/login-signup.php");
                        exit;
                    }
                else
                    {
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