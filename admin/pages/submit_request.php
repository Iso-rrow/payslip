<?php
session_start();
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $request_type = $_POST['request_type'];
    $notes = $_POST['notes'] ?? '';

    $stmt = $conn->prepare("INSERT INTO file_requests (employee_id, request_type, notes, request_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $employee_id, $request_type, $notes);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Request submitted successfully!";
    } else {
        $_SESSION['message'] = "Failed to submit request.";
    }

    header('Location: employeedashboard.php');
    exit;
}
?>
