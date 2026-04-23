<?php

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) 
        {
            header("Location: " . AUTH_F_URL . "auth.php");
            exit;
        }

?>