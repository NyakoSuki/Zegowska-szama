<?php
$protocol = (!empty($_SERVER['HTTPS']) ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

/* ================= PATH ================= */
define("WEB_PATH", dirname(__DIR__, 2) . "/");

    define("BACKEND_PATH", WEB_PATH . "backend/");
    define("PUBLIC_PATH",  WEB_PATH . "public/");



/* ================= URL ================= */
define("BASE_URL", $protocol . "://" . $host . "/Zegowska-szama/");
define("WEB_URL",  BASE_URL . "website/");

    define("BACKEND_URL", WEB_URL . "backend/");
    define("PUBLIC_URL", WEB_URL . "public/");