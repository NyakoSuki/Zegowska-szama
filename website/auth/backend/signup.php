<?php

session_start();

require_once dirname(__DIR__, 2) . "/config.php";
include DB_PATH;



function restartSession()
{
    $_SESSION = [];
    session_regenerate_id(true);
}



if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) exit;

if (mb_strlen($_POST["password"]) < 8) 
{
    restartSession();

    $_SESSION["error"] = "short_password";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

$username = trim($_POST["username"]);
$email = strtolower(trim($_POST["email"]));
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

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
    restartSession();

    $_SESSION['error'] = "user_exists";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

$stmt = $connection->prepare
("
    INSERT INTO users (username, email, password)
    VALUES (?, ?, ?)
");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("sss", $username, $email, $password);

if(!$stmt->execute()) exit("SQL execute error");


restartSession();

$_SESSION["error"] = "none";

header("Location: " . AUTH_F_URL . "auth.php");
exit;