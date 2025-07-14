<?php
session_start();
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE file_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $request_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Request status updated.";
    } else {
        $_SESSION['message'] = "Failed to update request.";
    }
}

header('Location: admin_requests.php');
exit;
