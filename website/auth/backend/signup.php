<?php

session_start();

require_once dirname(__DIR__, 2) . "/config.php";
include DB_PATH;


$username = trim($_POST["username"] ?? '');
$email = strtolower(trim($_POST["email"]) ?? '');
$password = $_POST["password"] ?? '';

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) exit;

if (mb_strlen($_POST["password"]) < 8) 
{
    session_regenerate_id(true);

    $_SESSION["error"] = "short";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

$stmt = $connection->prepare
("
    SELECT id FROM users 
    WHERE username = ? OR email = ?
");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("ss", $username, $email);
if(!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    session_regenerate_id(true);

    $_SESSION['error'] = "exists";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

$hashed = password_hash($current, PASSWORD_DEFAULT);

$stmt = $connection->prepare
("
    INSERT INTO users (username, email, password)
    VALUES (?, ?, ?)
");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("sss", $username, $email, $hashed);

if(!$stmt->execute()) exit("SQL execute error");


session_regenerate_id(true);

$_SESSION["error"] = "none";

header("Location: " . AUTH_F_URL . "auth.php");
exit;