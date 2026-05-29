<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/config/config.php";
include BACKEND_PATH . "database/database.php";

header('Content-Type: application/json');

// --- Guard: only POST ---
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Nieprawidłowa metoda"]);
    exit;
}

// --- Input ---
$id      = (int)($_POST["idInp"]     ?? 0);
$procent = (int)($_POST["procentInp"] ?? 0);
$start   = $_POST["startInp"] ?? "";
$end     = $_POST["endInp"]   ?? "";

$action  = $_POST["actionBtn"] ?? "";

// Normalize datetime-local → MySQL datetime
$start = str_replace("T", " ", $start);
$end   = str_replace("T", " ", $end);

// Parse product IDs (comma-separated, integers only)
// parse from checkbox array
$productsRaw = $_POST["productsInp"] ?? [];
$productIds = array_filter(
    array_map("intval", (array)$productsRaw),
    fn($v) => $v > 0
);

// --- Validate ---
if ($procent < 1 || $procent > 100)
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Procent musi być między 1 a 100"]);
    exit;
}
if (empty($start) || empty($end))
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Daty są wymagane"]);
    exit;
}
if ($start >= $end)
{
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Data końca musi być późniejsza niż data początku"]);
    exit;
}


// ============================================================
// DELETE
// ============================================================
if ($action === "delete")
{
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Brak ID"]);
        exit;
    }

    // Delete pivot rows first (FK)
    $stmt = $connection->prepare("DELETE FROM discounted_products WHERE discount_id = ?");
    if (!$stmt) { dbError($connection); }
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $connection->prepare("DELETE FROM discounts WHERE id = ?");
    if (!$stmt) { dbError($connection); }
    $stmt->bind_param("i", $id);

    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Błąd usuwania promocji"]);
        exit;
    }

    echo json_encode(["success" => true, "message" => "Promocja została usunięta"]);
    exit;
}


// ============================================================
// UPDATE
// ============================================================
if ($action === "update")
{
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Brak ID"]);
        exit;
    }

    $stmt = $connection->prepare
    ("
        UPDATE discounts
        SET procent = ?, start_date = ?, end_date = ?
        WHERE id = ?
    ");
    if (!$stmt) { dbError($connection); }
    $stmt->bind_param("issi", $procent, $start, $end, $id);

    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Błąd aktualizacji promocji"]);
        exit;
    }

    // Refresh pivot table for this discount
    syncProducts($connection, $id, $productIds);

    echo json_encode(["success" => true, "message" => "Promocja zaktualizowana"]);
    exit;
}


// ============================================================
// ADD
// ============================================================
if ($action === "add")
{
    $stmt = $connection->prepare
    ("
        INSERT INTO discounts (procent, start_date, end_date)
        VALUES (?, ?, ?)
    ");
    if (!$stmt) { dbError($connection); }
    $stmt->bind_param("iss", $procent, $start, $end);

    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Błąd dodawania promocji"]);
        exit;
    }

    $newId = $connection->insert_id;

    // Insert pivot rows
    syncProducts($connection, $newId, $productIds);

    echo json_encode(["success" => true, "message" => "Promocja została dodana"]);
    exit;
}

// Unknown action
http_response_code(400);
echo json_encode(["success" => false, "message" => "Nieznana akcja"]);
exit;


// ============================================================
// HELPERS
// ============================================================

/**
 * Replace all discounted_products rows for a given discount_id.
 */
function syncProducts(mysqli $conn, int $discountId, array $productIds): void
{
    // Remove old assignments
    $del = $conn->prepare("DELETE FROM discounted_products WHERE discount_id = ?");
    $del->bind_param("i", $discountId);
    $del->execute();

    if (empty($productIds)) return;

    // Insert new assignments
    $ins = $conn->prepare("INSERT INTO discounted_products (discount_id, product_id) VALUES (?, ?)");
    foreach ($productIds as $pid)
    {
        $ins->bind_param("ii", $discountId, $pid);
        $ins->execute();
    }
}

function dbError(mysqli $conn): never
{
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Błąd przygotowania zapytania: " . $conn->error]);
    exit;
}