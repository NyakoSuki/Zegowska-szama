<?php

    session_start();

    session_destroy();

    header("Location: ../../login-signup/login-signup.php");
    exit;
    
?>