<?php

session_start();

include "data_base.php";

//SPARWDZANIE METODY WYSŁANIA DANYCH
if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        //SPRAWDZANIE CZY EMAIL I HASŁO ZOSTAŁY WPISANE
        if (isset($_POST["emailLogin"], $_POST["passwordLogin"]))
            {
                $email = $connection->real_escape_string($_POST["emailLogin"]);
                $password = $_POST["passwordLogin"];

                $hashedPassword = $connection->query("SELECT password FROM users WHERE email = '$email'");
                //SPRAWDZANIE CZY EMAIL ISTNIEJE
                if($hashedPassword->num_rows === 0)
                    {
                        //JEZELI EMAIL NIE ISTNIEJE -> PRZEKIEROWANIE NA STRONĘ LOGOWANIA
                        $_SESSION['correctData'] = false;
                        header("Location: login-signup.php");
                        exit;
                    }
                else
                    {
                        //JEŻELI ISTNIEJE -> SPRAWDZANIE POPRAWNOŚCI HASŁA
                        $row = $hashedPassword->fetch_assoc();
                        if(password_verify($password, $row["password"]))
                            {
                                //JEŻELI POPRAWNE HASŁO -> PRZEKIEROWANIE NA STRONĘ SKLEPU
                                $_SESSION["loggedin"] = true;
                                header("Location: ../index/index.php");
                                exit;
                            }
                        else
                            {
                                //JEŻELI NIEPOPRAWNE HASŁO -> PRZEKIEROWANIE NA STRONĘ LOGOWANIA
                                $_SESSION['correctData'] = false;
                                header("Location: login-signup.php");
                                exit;
                            }    
                    }
            }
    }
?>