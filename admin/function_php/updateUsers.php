<?php
include '../../database/connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $employee_id = $_POST['employee_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';

    if (!$id || !$employee_id) {
        echo json_encode(['success' => false, 'message' => 'Missing user ID or employee ID.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET employee_id = ?, name = ?, email = ?, role = ? WHERE id = ?");

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('ssssi', $employee_id, $name, $email, $role, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed.']);
    }

    $stmt->close();
    $conn->close();
}
