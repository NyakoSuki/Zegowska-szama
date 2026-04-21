<?php

    session_start();

    function requireLogin()
    {
        if(!isset($_SESSION["loggedin"]))
            {
                header("Location: http://localhost/Zegowska-szama/files/login-signup/login-signup.php");
                exit;
            }
    }

?>