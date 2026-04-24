<?php

    session_start();

    require_once dirname(__DIR__, 3) . "/config.php";

    include DB_PATH;


    $id = $_SESSION["id"];

    

    
?>