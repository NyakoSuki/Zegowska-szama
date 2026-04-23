<?php

    session_start();

    require_once dirname(__DIR__, 3) . "/config.php";
    require_once BLOCKER_PATH;

    $_SESSION = [];
    session_unset();


    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
    
?>