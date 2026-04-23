<?php

    session_start();

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

                if(isset($_SESSION["usernameChange"]) && $_SESSION["usernameChange"] === false)
                    {
                        echo "<p>Ta nazwa jest już zajęta</p>";
                        unset($_SESSION["usernameChange"]);
                    }
            ?>

            <form action="<?=ACCOUNT_B_URL?>change-password.php" method="post">
                <input type="password">
                <input type="password">
                <input type="password">
                <button>Zmień hasło</button>
            </form>
            
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