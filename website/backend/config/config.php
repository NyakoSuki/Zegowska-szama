<?php
/* ================= PATH ================= */
define("BASE_PATH", dirname(__DIR__, 2) . "/");

    define("BACKEND_PATH", BASE_PATH . "backend/");
    define("PUBLIC_PATH", BASE_PATH . "public/");


/* ================= URL ================= */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

define("BASE_URL", $protocol . "://" . $host . "/Zegowska-szama/website/");

    define("BACKEND_URL", BASE_URL . "backend/");
    define("PUBLIC_URL", BASE_URL . "public/");