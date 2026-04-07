<?php

session_start();

include "data_base.php";

if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["usernameLogin"], $_POST["passwordLogin"]))
            {
                $username = $connection->real_escape_string($_POST["usernameLogin"]);
                $password = $_POST["passwordLogin"];

                $hashedPassword = $connection->query("SELECT password FROM users WHERE username='$username'");
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
                                header("Location: http://localhost/Zegowska-szama/files/index/index.html");
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