<?php

session_start();

include "data_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["emailLogin"], $_POST["passwordLogin"]))
            {
                $email = $connection->real_escape_string($_POST["emailLogin"]);
                $password = $_POST["passwordLogin"];

                $hashedPassword = $connection->query("SELECT password FROM users WHERE email = '$email'");
                if($hashedPassword->num_rows === 0)
                    {
                        $_SESSION['correctData'] = false;
                        header("Location: http://localhost/Zegowska-szama/files/login-signup/login-signup.php");
                        exit;
                    }
                else
                    {
                        $row = $hashedPassword->fetch_assoc();
                        if(password_verify($password, $row["password"]))
                            {
                                $_SESSION["loggedin"] = true;
                                header("Location: http://localhost/Zegowska-szama/files/index/index.php");
                                exit;
                            }
                        else
                            {
                                $_SESSION['correctData'] = false;
                                header("Location: http://localhost/Zegowska-szama/files/login-signup/login-signup.php");
                                exit;
                            }    
                    }
            }
    }
?>