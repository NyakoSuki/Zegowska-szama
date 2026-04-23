<?php

    session_start();
    
    require_once "config.php";

    function requireLogin()
    {
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false)
            {
                header("Location: website/auth/auth.php");
                exit;
            }
    }

?>