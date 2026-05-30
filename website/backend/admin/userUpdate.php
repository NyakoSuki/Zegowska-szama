<?php
session_start();
require_once dirname(__DIR__, 1) . "/config/config.php";
include BACKEND_PATH . "database/database.php";

header("Content-Type: application/json");

// GUARD – tylko POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Nieprawidłowa metoda żądania"]);
    exit;
}

$id     = (int)($_POST["user_id"] ?? 0);
$action = $_POST["action"] ?? "";

// GUARD – ID
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Brak ID użytkownika"]);
    exit;
}

// toggle_active
if ($action === "toggle_active") {
    $stmt = $connection->prepare("UPDATE users SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL error"]);
        exit;
    }

    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Zaktualizowano status użytkownika"]);
    exit;
}

// set_role
if ($action === "set_role") {
    $role = $_POST["role"] ?? "";

    if (!in_array($role, ["admin", "user"], true)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Nieprawidłowa rola"]);
        exit;
    }

    $stmt = $connection->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $id);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL error"]);
        exit;
    }

    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Zaktualizowano rolę użytkownika"]);
    exit;
}

// nieznana akcja
http_response_code(400);
echo json_encode(["success" => false, "message" => "Nieznana akcja"]);