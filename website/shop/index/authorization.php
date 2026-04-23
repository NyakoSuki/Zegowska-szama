<?php

    session_start();

    function requireLogin()
    {
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false)
            {
                header("Location: ../login-signup/login-signup.php");
                exit;
            }
    }

?>