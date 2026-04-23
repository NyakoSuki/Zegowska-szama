<?php

    session_start();

    require_once dirname(__DIR__, 4) . "/config.php";


    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $_SESSION['cart'][] = $id;
    }

    header("Location: " . HOME_URL ."home.php");
    exit;

?>