<?php

session_start();

require_once dirname(__DIR__, 2) . "/config.php";
include DB_PATH;



function restartSession()
{
    $_SESSION = [];
    session_regenerate_id(true);
}



// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($_POST["email"]) || empty($_POST["password"])) exit;

$email = strtolower(trim($_POST["email"]));
$password = $_POST["password"];

$stmt = $connection->prepare
("
    SELECT id, password, role, failed_attempts, last_failed_login 
    FROM users 
    WHERE email = ?
");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("s", $email);

if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

// USER NOT FOUND
if ($result->num_rows === 0) 
{
    restartSession();

    $_SESSION['error'] = "invalid_credentials";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

$user = $result->fetch_assoc();

// LOCK CHECK
$now = new DateTime();
$lastFail = $user["last_failed_login"] ? new DateTime($user["last_failed_login"]) : null;

if 
(
    $user['failed_attempts'] >= 5 &&
    $lastFail &&
    ($now->getTimestamp() - $lastFail->getTimestamp() < 300)
) 
{
    restartSession();

    $_SESSION["error"] = "locked";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

// PASSWORD CHECK
if (!password_verify($password, $user["password"])) 
{

    $stmt = $connection->prepare("
        UPDATE users 
        SET failed_attempts = failed_attempts + 1,
            last_failed_login = NOW()
        WHERE email = ?
    ");

    if (!$stmt) exit("SQL prepare error");

    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) exit("SQL execute error");

    restartSession();

    $_SESSION['error'] = "invalid_credentials";

    header("Location: " . AUTH_F_URL . "auth.php");
    exit;
}

// SUCCESS LOGIN
$stmt = $connection->prepare
("
    UPDATE users 
    SET last_login = NOW(),
        failed_attempts = 0,
        last_failed_login = NULL
    WHERE email = ?
");

$stmt->bind_param("s", $email);

if (!$stmt->execute()) exit("SQL execute error");


restartSession();

$_SESSION["id"] = $user["id"];
$_SESSION["role"] = $user["role"];

header("Location: " . HOME_URL . "home.php");
exit;