<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$id = $_SESSION["id"] ?? "";
$username = trim($_POST["username"] ?? "");


// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if (empty($username)) exit;


// CHECK IF USERNAME IS TAKEN
$stmt = $connection->prepare
("
    SELECT id 
    FROM users 
    WHERE username = ? AND id != ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("si", $username, $id);
    if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    session_regenerate_id(true);
    $_SESSION["error"] = "used";

    header("Location: " . PUBLIC_URL . "html/account/account.php");
    exit;
}


// UPDATE USERNAME
$stmt = $connection->prepare
("
    UPDATE users 
    SET username = ? 
    WHERE id = ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("si", $username, $id);
    if (!$stmt->execute()) exit("SQL execute error");


// SUCCESS
session_regenerate_id(true);
$_SESSION["error"] = "unone";

header("Location: " . PUBLIC_URL . "html/account/account.php");
exit;