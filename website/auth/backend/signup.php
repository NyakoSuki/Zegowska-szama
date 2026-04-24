<?php

    session_start();

    require_once dirname(__DIR__, 2) . "/config.php";

    include DB_PATH;

    
    //SPARWDZANIE METODY WYSŁANIA DANYCH
    if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            //SPRAWDZANIE CZY NAZWA, EMAIL I HASŁO ZOSTAŁY WPISANE
            if (isset($_POST["usernameSignup"], $_POST["emailSignup"], $_POST["passwordSignup"]))
                {
                    //PREPERED STATEMENT -> ZABEZPIECZA PRZED SQL INJECTION
                    $username = trim($_POST["usernameSignup"]);
                    $email = trim($_POST["emailSignup"]);
                    $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);

                    $select = $connection->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                    if (!$select) 
                        {
                            die("SQL error: " . $connection->error);
                        }
                    $select->bind_param("ss", $username, $email);
                    $select->execute();
                    $selected = $select->get_result();

                    //SPRAWDZANIE CZY USERNAME LUB EMAIL SĄ ZAJĘTE
                    if($selected->num_rows > 0)
                        {
                            $_SESSION['userExists'] = true;

                            header("Location: " . AUTH_F_URL . "auth.php");
                            exit;
                        }
                    else
                        {
                            //JEŻELI USERNAME LUB EMAIL NIE SĄ ZAJĘTE -> REJESTRACJA
                            $createUser = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                            if (!$createUser) 
                                {
                                    die("SQL error: " . $connection->error);
                                }
                            $createUser->bind_param("sss", $username, $email, $password);
                            if($createUser->execute())
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