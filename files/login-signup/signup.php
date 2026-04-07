<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Zegowska Szama</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<?php

include "data_base.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_POST["usernameSignup"], $_POST["emailSignup"], $_POST["passwordSignup"]))
            {

                $username = $connection->real_escape_string($_POST["usernameSignup"]);
                $email = $connection->real_escape_string($_POST["emailSignup"]);
                $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);

                $numberOfRows = $connection->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
                if($numberOfRows->num_rows > 0)
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
</body>
</html>