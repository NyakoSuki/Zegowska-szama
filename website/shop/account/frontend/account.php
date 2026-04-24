<?php

    require_once dirname(__DIR__, 3) . "/config.php";
    require_once BLOCKER_PATH;

    include DB_PATH;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto - Zegowska szama</title>
</head>
<body>
    <header>

    </header>
    <main>

        <section>
            <?php

                $id = $_SESSION["id"];

                $select = $connection->prepare("SELECT username FROM users WHERE id = ?");
                if (!$select) 
                    {
                        die("SQL error: " . $connection->error);
                    }
                $select->bind_param("i", $id);
                $select->execute();
                $selected = $select->get_result();

                $row = $selected->fetch_assoc();

                echo "<h1>".$row["username"]."</h1>";

            ?>
        </section>

        <div>

            <form action="<?=ACCOUNT_B_URL?>change-username.php" method="post">
                <input type="text" name="username">
                <button>Zmień nazwę</button>
            </form>

            <?php
                if(isset($_SESSION["error"]))
                {
                    switch($_SESSION["error"])
                    {
                        case "used" : echo "<h4 class='error'>Nazwa użytkownika zajęta</h4>"; break;
                    }
                }
            ?>


            <form action="<?=ACCOUNT_B_URL?>change-password.php" method="post">
                <input type="password" name="current">
                <input type="password" name="new">
                <input type="password" name="confirm">
                <button>Zmień hasło</button>
            </form>

            <?php
                if(isset($_SESSION["error"]))
                {
                    switch($_SESSION["error"])
                    {
                        case "uncorrect" : echo "<h4 class='error'>Obecne hasło jest niepoprawne</h4>"; break;
                        case "notsame" : echo "<h4 class='error'>Hasła są różne</h4>"; break;
                        case "short" : echo "<h4 class='error'>Hasło jest zbyt krótkie</h4>"; break;
                        case "old" : echo "<h4 class='error'>Nowe hasło nie może być takie samo jak stare</h4>"; break;
                        case "none" : echo "<h4 class='success'>Pomyślnie zmieniono hasło</h4>"; break;
                    }
                    unset($_SESSION["error"]);
                }
            ?>

            
            <form action="<?=ACCOUNT_F_URL?>orders.php" method="post">
                <button>Zamówienia</button>
            </form>


            <form action="<?=ACCOUNT_B_URL?>logout.php" method="post">
                <button>Wyloguj się</button>
            </form>
        </div>

    </main>
    <footer>

    </footer>
</body>
</html>