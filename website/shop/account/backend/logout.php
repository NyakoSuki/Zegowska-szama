<?php

    session_start();

    require_once dirname(__DIR__, 3) . "/config.php";

    $_SESSION = [];
    session_unset();


    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
    
?>