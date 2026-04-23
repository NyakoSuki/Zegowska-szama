<?php

    session_start();

    require_once dirname(__DIR__, 2) . "/config.php";

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) 
        {
            header("Location: " . AUTH_F_URL . "auth.php");
            exit;
        }

?>