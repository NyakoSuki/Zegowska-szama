<?php
session_start();

require_once dirname(__DIR__, 3) . "/config.php";
include DB_PATH;


$id = (int)($_POST["id"] ?? 0);

$username = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$role = $_POST["role"] ?? "";
$active = isset($_POST["active"]) ? 1 : 0;


// GUARD CLAUSES
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;
if ($id <= 0 || $username === "" || $email === "" || $role === "") exit;


$stmt = $connection->prepare
("
    SELECT id 
    FROM users 
    WHERE (username = ? OR email = ?) AND id != ?
");
    if (!$stmt) exit("SQL prepare error");

$stmt->bind_param("ssi", $username, $email, $id);
    if (!$stmt->execute()) exit("SQL execute error");

$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    session_regenerate_id(true);
    $_SESSION["error"] = "used";

    header("Location: " . ADMIN_F_URL . "admin.php");
    exit;
}


$stmt = $connection->prepare
("
    UPDATE users 
    SET username = ?, email = ?, role = ?, is_active = ?
    WHERE id = ?
");
    if (!$stmt) exit("SQL prepare error");
$stmt->bind_param
(
    "sssii",
    $username,
    $email,
    $role,
    $active,
    $id
);

if (!$stmt->execute()) exit("SQL execute error");


header("Location: " . ADMIN_F_URL . "admin.php");
exit;
