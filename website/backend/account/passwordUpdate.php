<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$id = $_SESSION["id"] ?? "";
$current = $_POST["current"] ?? "";
$new = $_POST["new"] ?? "";
$confirm = $_POST["confirm"] ?? "";


// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($current) || empty($new) || empty($confirm)) exit;


// PASSWORD LENGTH CHECK
if (mb_strlen($new) < 8)
{
    session_regenerate_id(true);
    $_SESSION["error"] = "short";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
    exit;
}


// PASSWORD MATCH CHECK
if ($new !== $confirm)
{
    session_regenerate_id(true);
    $_SESSION["error"] = "notsame";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
    exit;
}


// GET CURRENT PASSWORD HASH
$stmt = $connection->prepare
("
    SELECT password 
    FROM users 
    WHERE id = ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("i", $id);
    if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();
$row = $result->fetch_assoc();


// CHECK IF NEW PASSWORD IS SAME AS OLD
if (password_verify($new, $row["password"]))
{
    session_regenerate_id(true);
    $_SESSION["error"] = "old";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
    exit;
}


// VERIFY CURRENT PASSWORD
if (!password_verify($current, $row["password"]))
{
    session_regenerate_id(true);
    $_SESSION["error"] = "uncorrect";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
    exit;
}


// HASH NEW PASSWORD
$hashed = password_hash($new, PASSWORD_DEFAULT);


// UPDATE PASSWORD
$stmt = $connection->prepare
("
    UPDATE users 
    SET password = ? 
    WHERE id = ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("si", $hashed, $id);
    if (!$stmt->execute()) exit("SQL execute error");


// SUCCESS
session_regenerate_id(true);
$_SESSION["error"] = "pnone";

header("Location: " . PUBLIC_URL . "html/account/account.php");
exit;