<?php

include "data_base.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_POST["usernameSignup"], $_POST["emailSignup"], $_POST["passwordSignup"]))
            {

                $username = $connection->real_escape_string($_POST["usernameSignup"]);
                $email = $connection->real_escape_string($_POST["emailSignup"]);
                $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);

                $checkNumOfRows = $connection->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
                if($checkNumOfRows->num_rows > 0)
                    {
                        echo "Użytkownik lub email już istnieje";
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
                                echo "Error". $connection -> error;
                            }
                    }
            }
    }

?>