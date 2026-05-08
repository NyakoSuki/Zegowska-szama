<?php
$protocol = (!empty($_SERVER['HTTPS']) ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

$base = ($protocol . "://" . $host . "/Zegowska-szama/");
$website = $base . "website/";
?>

<script>
window.CONFIG =
{
    /* ================= BASE ================= */
    PROTOCOL: "<?= $protocol ?>",
    HOST: "<?= $host ?>",

    BASE_URL: "<?= $base ?>",

    /* ================= BACKEND ================= */
    BACKEND_URL: "<?= $website ?>backend/",

    ACCOUNT_URL: "<?= $website ?>backend/account/",
    ADMIN_URL: "<?= $website ?>backend/admin/",
    AUTH_URL: "<?= $website ?>backend/auth/",
    CART_URL: "<?= $website ?>backend/cart/",
    CONFIG_URL: "<?= $website ?>backend/config/",
    DATABASE_URL: "<?= $website ?>backend/database/",
    SHARED_URL: "<?= $website ?>backend/shared/",
    SHOP_URL: "<?= $website ?>backend/shop/",

    /* ================= PUBLIC ================= */
    PUBLIC_URL: "<?= $website ?>public/",

    CSS_URL: "<?= $website ?>public/css/",
    IMG_URL: "<?= $website ?>public/img/",
    PRODUCT_URL: "<?= $website ?>public/img/product/",
    HTML_URL: "<?= $website ?>public/html/",
    JS_URL: "<?= $website ?>public/js/",
};
</script>