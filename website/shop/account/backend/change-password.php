<?php

session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


$id = $_SESSION["id"] ?? '';
$current = $_POST["current"] ?? '';
$new = $_POST["new"] ?? '';
$confirm = $_POST["confirm"] ?? '';

if (empty($current) || empty($new) || empty($confirm)) exit;

if(mb_strlen($new) < 8)
{
    session_regenerate_id(true);

    $_SESSION["error"] = "short";
    
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

if($new !== $confirm)
{
    session_regenerate_id(true);

    $_SESSION["error"] = "notsame";
    
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

$stmt = $connection->prepare("SELECT password FROM users WHERE id = ?");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("i", $id);

if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

$row = $result->fetch_assoc();

if(password_verify($new, $row["password"]))
{
    session_regenerate_id(true);

    $_SESSION["error"] = "old";
    
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

if(!password_verify($current, $row["password"]))
{
    session_regenerate_id(true);

    $_SESSION["error"] = "uncorrect";
    
    header("Location: " . ACCOUNT_F_URL . "account.php");
    exit;
}

$hashed = password_hash($new, PASSWORD_DEFAULT);

$stmt = $connection->prepare("UPDATE users SET password = ? where id = ?");

if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("si",$hashed ,$id);

if (!$stmt->execute()) exit("SQL execute error");

session_regenerate_id(true);

$_SESSION["error"] = "none";
    
header("Location: " . ACCOUNT_F_URL . "account.php");
exit;