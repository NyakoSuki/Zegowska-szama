<?php

    session_start();

    require_once dirname(__DIR__, 2) . "/config.php";

    include DB_PATH;


    //SPARWDZANIE METODY WYSŁANIA DANYCH
    if ($_SERVER["REQUEST_METHOD"] === "POST")
        {
            //SPRAWDZANIE CZY EMAIL I HASŁO ZOSTAŁY WPISANE
            if (isset($_POST["emailLogin"], $_POST["passwordLogin"]))
                {
                    $email = $_POST["emailLogin"];
                    $password = $_POST["passwordLogin"];

                    $stmt = $connection->prepare("SELECT password, role, failed_attempts, last_failed_login FROM users WHERE email = ?");
                    if (!$stmt) 
                        {
                            die("SQL error: " . $connection->error);
                        }
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();


                    //SPRAWDZANIE CZY EMAIL ISTNIEJE
                    if($result->num_rows === 0)
                        {
                            //JEZELI EMAIL NIE ISTNIEJE -> PRZEKIEROWANIE NA STRONĘ LOGOWANIA
                            $_SESSION['correctData'] = false;

                            header("Location: " . AUTH_F_URL . "auth.php");
                            exit;
                        }

                        
                    //JEŻELI ISTNIEJE -> SPRAWDZANIE POPRAWNOŚCI HASŁA ORAZ PRÓB LOGOWANIA
                    $row = $result->fetch_assoc();
                    
                    $now = new DateTime();
                    $lastFailedLogin = $row["last_failed_login"] ? new DateTime($row["last_failed_login"]) : null;
                    $failedAttempts = $row["failed_attempts"];


                    //JEŻELI WYKORZYSTANO WSZYSTKIE -> PRZEKIEROWANIE NA STRONĘ LOGOWANIA
                    if ($row['failed_attempts'] >= 5 && $lastFailedLogin !== null && $now->getTimestamp() - $lastFailedLogin->getTimestamp() < 300)
                        {
                            $_SESSION["failed"] = true;
                            header("Location: " . AUTH_F_URL . "auth.php");
                            exit;
                        }
                    

                    //JEŻELI NIE WYKORZYSTANO WSZYSTKICH -> SPRAWDZANIE HASŁA
                    if(!password_verify($password, $row["password"]))
                        {
                            //JEŻELI NIEPOPRAWNE HASŁO -> ZWIĘKSZENIE NIEUDANYCH PRÓB I PRZEKIEROWANIE NA STRONĘ LOGOWANIA
                            $increaseFailed = $connection->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_login = NOW() where email = ?");
                            $increaseFailed->bind_param("s", $email);
                            $increaseFailed->execute();
                            
                            $_SESSION['correctData'] = false;
                            header("Location: " . AUTH_F_URL . "auth.php");
                            exit;
                        }


                        //JEŻELI POPRAWNE HASŁO -> PRZEKIEROWANIE NA STRONĘ SKLEPU
                        $resetFailed = $connection->prepare("UPDATE users SET last_login = NOW(), failed_attempts = 0, last_failed_login = null where email = ?");
                        $resetFailed->bind_param("s", $email);
                        $resetFailed->execute();

                        session_regenerate_id(true);

                        $_SESSION["failed"] = false;
                        $_SESSION["loggedin"] = true;
                        $_SESSION["role"] = $row["role"];

                        header("Location: " . HOME_URL . "home.php");
                        exit; 
                }
        }
?>