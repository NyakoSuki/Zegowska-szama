<?php

    session_start();

    require_once dirname(__DIR__, 3) . "/config.php";
    require_once BLOCKER_PATH;

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

    if($selected->num_rows > 0)
        {
            $_SESSION["usernameChange"] = false;

            header("Location: " . ACCOUNT_F_URL . "account.php");
            exit;
        }
    
    $usernameChange = $connection->prepare("UPDATE users SET username = ? WHERE id = ?");
    if (!$usernameChange) 
        {
            die("SQL error: " . $connection->error);
        }
    $usernameChange->bind_param("si", $username, $id);
    if (!$usernameChange->execute()) 
        {
            die("Update failed: " . $usernameChange->error);
        }


    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
?>