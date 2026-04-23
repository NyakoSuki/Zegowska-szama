<?php

    session_start();
    session_destroy();

    require_once dirname(__DIR__, 3) . "/config.php";

    include DB_PATH;


    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
    
?>