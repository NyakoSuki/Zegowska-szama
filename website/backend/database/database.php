<?php
require_once dirname(__DIR__, 2) . "/backend/config/config.php";

$host = "localhost";
$user = "root";
$password = "";
$dataBase = "zegowskaszama";

$connection = new mysqli($host,$user,$password,$dataBase);
mysqli_set_charset($connection, "utf8mb4");

if($connection -> connect_error) exit("błąd połączenia".$connection -> connect_error);