<?php

    require_once dirname(__DIR__, 1) . "/config.php";


    $host = "localhost";
    $user = "root";
    $password = "";
    $dataBase = "zegowskaszama";

    $connection = new mysqli($host,$user,$password,$dataBase);

    if($connection -> connect_error)
        {
            die("błąd połączenia".$connection -> connect_error);
        }

?>