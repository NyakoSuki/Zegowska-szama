<?php
$protocol = (!empty($_SERVER['HTTPS']) ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

/* ================= BASE PATH (Ścieżki systemowe) ================= */
define("BASE_PATH", dirname(__DIR__, 2) . "/");

    /* ================= BACKEND PATHS ================= */
    define("BACKEND_PATH", BASE_PATH . "backend/");

    define("ACCOUNT_B",    BACKEND_PATH . "account/");
    define("ADMIN_B",      BACKEND_PATH . "admin/");
    define("AUTH_B",       BACKEND_PATH . "auth/");
    define("CART_B",       BACKEND_PATH . "cart/");
    define("CONFIG_B",     BACKEND_PATH . "config/");
    define("DATABASE_B",   BACKEND_PATH . "database/");
    define("SHARED_B",     BACKEND_PATH . "shared/");
    define("SHOP_B",       BACKEND_PATH . "shop/");

    /* ================= PUBLIC PATHS ================= */
    define("PUBLIC_PATH",  BASE_PATH . "public/");

    define("CSS_PATH",     PUBLIC_PATH . "css/");
    define("IMG_PATH",     PUBLIC_PATH . "img/");
    define("HTML_PATH",    PUBLIC_PATH . "html/");
    define("JS_PATH",      PUBLIC_PATH . "js/");

    /* ================= SPECIAL FILES ================= */
    define("SITE_BLOCKER", SHARED_B . "siteblocker.php");
    define("DATABASE_FILE", DATABASE_B . "database.php");
    define("JS_CONFIG", CONFIG_B . "config.js.php");


/* ================= BASE URL (Adresy URL) ================= */
define("BASE_URL", $protocol . "://" . $host . "/Zegowska-szama/");
define("WEB_URL",  BASE_URL . "website/");
define("PUBL_URL", WEB_URL . "public/");

    /* ================= CSS URL ================= */
    define("CSS_URL", PUBL_URL . "css/");

    /* ================= IMG URL ================= */
    define("IMG_URL", PUBL_URL . "img/");

    define("IMG_PRODUCTS", IMG_URL . "products/");

    /* ================= HTML URL ================= */
    define("HTML_URL",      PUBL_URL . "html/");

    define("HTML_ACCOUNT",  HTML_URL . "account/");
    define("HTML_ADMIN",    HTML_URL . "admin/");
    define("HTML_AUTH",     HTML_URL . "auth/");
    define("HTML_CART",     HTML_URL . "cart/");
    define("HTML_SHARED",   HTML_URL . "shared/");
    define("HTML_SHOP",     HTML_URL . "shop/");

    /* ================= JS URL ================= */
    define("JS_URL",        PUBL_URL . "js/");

    define("JS_ACCOUNT",    JS_URL . "account/");
    define("JS_ADMIN",      JS_URL . "admin/");
    define("JS_AUTH",       JS_URL . "auth/");
    define("JS_CART",       JS_URL . "cart/");
    define("JS_SHARED",     JS_URL . "shared/");
    define("JS_SHOP",       JS_URL . "shop/");