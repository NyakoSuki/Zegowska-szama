<?php

    session_start();

    function requireLogin()
    {
        if(!isset($_SESSION["loggedin"]))
            {
                header("Location: ../login-signup/login-signup.php");
                exit;
            }
    }

?>