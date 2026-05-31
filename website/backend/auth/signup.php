<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$username = trim($_POST["username"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$password = $_POST["password"] ?? "";


// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    $_SESSION['signup'] = true;
    header("Location: " . PUBLIC_URL . "html/auth/auth.php"); 
    exit;
}
if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]))
{
    $_SESSION['signup'] = true;
    header("Location: " . PUBLIC_URL . "html/auth/auth.php"); 
    exit;
}


// CHECK IF USER EXISTS
$stmt = $connection->prepare
("
    SELECT id 
    FROM users 
    WHERE username = ? OR email = ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("ss", $username, $email);
    if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    session_regenerate_id(true);
    $_SESSION['signup'] = true;
    $_SESSION["error"] = "exists";

    header("Location: " . PUBLIC_URL . "html/auth/auth.php");
    exit;
}

// PASSWORD LENGTH CHECK
if (mb_strlen($password) < 8) 
{
    session_regenerate_id(true);
    $_SESSION['signup'] = true;
    $_SESSION["error"] = "short";

    header("Location: " . PUBLIC_URL . "html/auth/auth.php");
    exit;
}


// HASH PASSWORD
$hashed = password_hash($password, PASSWORD_DEFAULT);


// INSERT USER
$stmt = $connection->prepare
("
    INSERT INTO users (username, email, password)
    VALUES (?, ?, ?)
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("sss", $username, $email, $hashed);
    if (!$stmt->execute()) exit("SQL execute error");


// SUCCESS
session_regenerate_id(true);
$_SESSION['signup'] = true;
$_SESSION["error"] = "none";

    header("Location: " . PUBLIC_URL . "html/auth/auth.php");
exit;