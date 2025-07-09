<?php
// api/employees/delete.php

include '../../database/connect.php';
header('Content-Type: application/json');

// Get employee_id (from URL, query, or POST/DELETE data)
// For RESTful routing with .htaccess, you might parse it from $_SERVER['REQUEST_URI']
// Here, we'll use query param for simplicity: /api/employees/delete.php?employee_id=123

$employee_id = intval($_REQUEST['employee_id'] ?? 0);

if ($employee_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid Employee ID.']);
    exit;
}

// Optional: check if employee exists before delete

$stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
$stmt->bind_param('i', $employee_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Employee deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Employee not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Delete failed.']);
}

$stmt->close();
$conn->close();
exit;
