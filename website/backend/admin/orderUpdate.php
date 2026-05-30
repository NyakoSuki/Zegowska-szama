<?php
session_start();
require_once dirname(__DIR__, 1) . "/config/config.php";
include BACKEND_PATH . "database/database.php";


// INPUT DATA
$id     = (int)($_POST["order_id"] ?? 0);
$status = $_POST["status"] ?? "";
$action = $_POST["actionBtn"] ?? "";


// GUARD – tylko POST
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    http_response_code(400);
    echo json_encode
    ([
        "success" => false,
        "message" => "Nieprawidłowa metoda żądania"
    ]);
    exit;
}

// GUARD – poprawny status
if (!in_array($status, ["pending", "ready", "claimed", "canceled"], true))
{
    http_response_code(400);
    echo json_encode
    ([
        "success" => false,
        "message" => "Nieprawidłowy status"
    ]);
    exit;
}


// DELETE ORDER (claimed / canceled)
if ($action === "delete")
{
    // GUARD
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode
        ([
            "success" => false,
            "message" => "Brak ID zamówienia"
        ]);
        exit;
    }

    $connection->query("DELETE FROM ordered_products WHERE order_id = $id");
    $connection->query("DELETE FROM orders WHERE id = $id");

    if ($connection->errno)
    {
        http_response_code(500);
        echo json_encode
        ([
            "success" => false,
            "message" => "SQL error"
        ]);
        exit;
    }

    header("Content-Type: application/json");

    http_response_code(200);
    echo json_encode
    ([
        "success" => true,
        "message" => "Pomyślnie usunięto zamówienie"
    ]);
    exit;
}


// UPDATE ORDER STATUS (pending / ready)
if ($action === "update")
{
    // GUARD
    if (empty($id))
    {
        http_response_code(400);
        echo json_encode
        ([
            "success" => false,
            "message" => "Brak ID zamówienia"
        ]);
        exit;
    }

    $stmt = $connection->prepare
    ("
        UPDATE orders
        SET status = ?
        WHERE id = ?
    ");
        if (!$stmt)
        {
            http_response_code(500);
            echo json_encode
            ([
                "success" => false,
                "message" => "SQL error"
            ]);
            exit;
        }

    $stmt->bind_param
    (
        "si",
        $status,
        $id
    );

    // EXECUTE UPDATE
    if (!$stmt->execute())
    {
        http_response_code(500);
        echo json_encode
        ([
            "success" => false,
            "message" => "SQL error"
        ]);
        exit;
    }

    header("Content-Type: application/json");

    http_response_code(200);
    echo json_encode
    ([
        "success" => true,
        "message" => "Pomyślnie zaktualizowano status zamówienia"
    ]);
    exit;
}