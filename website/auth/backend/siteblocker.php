<?php

    session_start();

    require_once dirname(__DIR__, 2) . "/config.php";

    if (!isset($_SESSION["id"])) 
    {
        header("Location: " . AUTH_F_URL . "auth.php");
        exit;
    }