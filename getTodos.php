<?php
require_once "connect.php";

header("Content-Type: application/json");

$sql = "SELECT id, task, finished FROM todo ORDER BY id ASC";
$result = $conn->query($sql);

$todos = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $todos[] = $row;
    }
}

echo json_encode($todos);

$conn->close();
