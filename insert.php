<?php
// adatbázis kapcsolat betöltése
require_once "connect.php"; // ahol a $conn van (a kódod)

// csak POST engedélyezett
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Csak POST kérés engedélyezett"]);
    exit;
}

// JSON beolvasása
$input = json_decode(file_get_contents("php://input"), true);

// ellenőrzés
if (!isset($input['task'])) {
    http_response_code(400);
    echo json_encode(["error" => "Hiányzó mező: task"]);
    exit;
}

$task = $input['task'];
$finished = isset($input['finished']) ? (int)$input['finished'] : 0;

// SQL beszúrás
$sql = "INSERT INTO todo (task, finished) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "SQL hiba"]);
    exit;
}

$stmt->bind_param("si", $task, $finished);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "id" => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Beszúrás sikertelen"]);
}

$stmt->close();
$conn->close();
