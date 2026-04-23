<?php

    session_start();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $_SESSION['cart'][] = $id;
    }

    header("Location: index.php");
    exit;

?>