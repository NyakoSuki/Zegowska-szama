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
    <title>Konto</title>
</head>
<body>
    <header>

    </header>
    <main>

        <div>

            <form action="<?=ACCOUNT_B_URL?>change-username.php" method="post">
                <input type="text">
                <button>Zmień nazwę</button>
            </form>

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
                <button>Logout</button>
            </form>
        </div>

    </main>
    <footer>

    </footer>
</body>
</html>