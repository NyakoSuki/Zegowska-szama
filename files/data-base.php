<?php

    $host = "localhost";
    $user = "root";//login-signup
    $password = "";//bardzo_ciezkie_haslo_do_zgadniecia_bo_tak_powiedzialem
    $dataBase = "zegowskaszama";

    $connection = new mysqli($host,$user,$password,$dataBase);

    if($connection -> connect_error)
        {
            die("błąd połączenia".$connection -> connect_error);
        }

?>