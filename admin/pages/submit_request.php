<?php
session_start();
include '../../database/connect.php';

if (!isset($_SESSION['employee_id'])) {
    header('Location: /payslip/authentication/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_SESSION['employee_id']; 
    $request_type = $_POST['request_type'];
    $notes = $_POST['notes'] ?? '';


    $status = 'Pending';
    $department_status = 'Pending';
    $final_status = 'Pending';
    $approved_by = null;
    $final_approved_by = null;

    $stmt = $conn->prepare("INSERT INTO file_requests 
        (employee_id, request_type, notes, request_date, status, department_approval_status, final_approval_status, approved_by, final_approved_by) 
        VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?)");


    $stmt->bind_param(
        "issssssss", 
        $employee_id,
        $request_type,
        $notes,
        $status,
        $department_status,
        $final_status,
        $approved_by,
        $final_approved_by
    );

    if ($stmt->execute()) {
        $_SESSION['message'] = " Request submitted successfully!";
    } else {
        $_SESSION['message'] = " Failed to submit request: " . $stmt->error;
    }


    header('Location: /payslip/admin/pages/employeedashboard.php');
    exit;
}
?>
