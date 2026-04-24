<?php


/* ================= PATHS ================= */


/* ================= BASE ================= */
define("BASE_PATH",  __DIR__ . "/");


    /* ================= SITE BLOCKER ================= */
    define("BLOCKER_PATH", BASE_PATH . "auth/backend/siteblocker.php");


    /* ================= DATA BASE ================= */
    define("DB_PATH", BASE_PATH . "database/database.php");


/* ================= URLS ================= */


/* ================= BASE ================= */
define("BASE_URL", "/Zegowska-szama/");


    /* ================= WEB ================= */
    define("WEB_URL", BASE_URL . "website/");


        /* ================= AUTH ================= */
        define("AUTH_URL", WEB_URL . "auth/");
        define("AUTH_B_URL", AUTH_URL . "backend/");
        define("AUTH_F_URL", AUTH_URL . "frontend/");

        /* ================= SHOP ================= */
        define("SHOP_URL", WEB_URL . "shop/");


            /* ================= CART ================= */
            define("CART_URL", SHOP_URL . "cart/");
            define("CART_B_URL", CART_URL . "backend/");
            define("CART_F_URL", CART_URL . "frontend/");


            /* ================= ACCOUNT ================= */
            define("ACCOUNT_URL", SHOP_URL . "account/");
            define("ACCOUNT_B_URL", ACCOUNT_URL . "backend/");
            define("ACCOUNT_F_URL", ACCOUNT_URL . "frontend/");


            /* ================= HOME ================= */
            define("HOME_URL", SHOP_URL . "home/");
            define("HOME_B_URL", HOME_URL . "backend/");
            define("HOME_F_URL", HOME_URL . "frontend/");


    /* ================= ASSETS ================= */
    define("ASSETS_URL", BASE_URL . "assets/");
    define("JS_URL", ASSETS_URL . "js/");
    define("CSS_URL", ASSETS_URL . "css/");
    define("IMG_URL", ASSETS_URL . "img/");

    
?>