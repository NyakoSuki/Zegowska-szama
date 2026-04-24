<?php

    session_start();

    require_once dirname(__DIR__, 3) . "/config.php";

    include DB_PATH;


    $id = $_SESSION["id"];
    $username = trim($_POST["username"] ?? '');
    
    $select = $connection->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    if (!$select) 
        {
            die("SQL error: " . $connection->error);
        }
    $select->bind_param("si", $username, $id);
    $select->execute();
    $selected = $select->get_result();

    if($selected->num_rows > 0 || $username === '')
        {
            $_SESSION["isUsed"] = false;

            header("Location: " . ACCOUNT_F_URL . "account.php");
            exit;
        }
    
    $newUsername = $connection->prepare("UPDATE users SET username = ? WHERE id = ?");
    if (!$newUsername) 
        {
            die("SQL error: " . $connection->error);
        }
    $newUsername->bind_param("si", $username, $id);
    if (!$newUsername->execute()) 
        {
            die("Update failed: " . $newUsername->error);
        }

    unset($_SESSION["isUsed"]);

    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
?>