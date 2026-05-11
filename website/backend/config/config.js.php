<?php
$protocol = (!empty($_SERVER['HTTPS']) ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

$base = ($protocol . "://" . $host . "/Zegowska-szama/");
?>

<script>
window.CONFIG =
{
    /* ================= BASE ================= */
    PROTOCOL: "<?= $protocol ?>",
    HOST: "<?= $host ?>",
    BASE_URL: "<?= $base ?>",

        BACKEND_URL: "<?= $base ?>website/backend/",
        PUBLIC_URL: "<?= $base ?>website/public/",


};
</script>