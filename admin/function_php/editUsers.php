<?php
header('Content-Type: application/json');
include "../../database/connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'User ID not provided']);
}
