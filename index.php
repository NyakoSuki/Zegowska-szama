<?php

    require_once "config.php";
    require_once "authorization.php";

    $page = $_GET['page'] ?? 'home';

    switch ($page)
    {
        case 'dashboard':
            requireLogin();
            require "website/auth/auth.php"; break;
        default:
            require "website/shop/home/home.php";

}