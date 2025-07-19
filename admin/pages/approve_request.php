<?php 
session_start();
include __DIR__ . '/../../database/connect.php'; 

$request_id = $_POST['request_id'];
$action = $_POST['action']; 
$user_id = $_SESSION['employee_id'];


$stmt = $conn->prepare("SELECT e.department, e.position, r.name AS role_name FROM employees e LEFT JOIN roles r ON e.position = r.id WHERE e.employee_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$approver = $result->fetch_assoc();

$role_name = strtolower($approver['role_name']);
$status = ($action === 'approve') ? 'Approved' : 'Declined';


$reqCheck = $conn->prepare("SELECT department_approval_status FROM file_requests WHERE id = ?");
$reqCheck->bind_param("i", $request_id);
$reqCheck->execute();
$reqResult = $reqCheck->get_result();
$request = $reqResult->fetch_assoc();


if (strpos($role_name, 'head') !== false || strpos($role_name, 'supervisor') !== false) {
    $update = $conn->prepare("UPDATE file_requests SET department_approval_status = ?, approved_by = ? WHERE id = ?");
    $update->bind_param("sii", $status, $user_id, $request_id);
    $update->execute();
}


elseif ($role_name === 'admin' && $request['department_approval_status'] === 'Approved') {
    $update = $conn->prepare("UPDATE file_requests SET final_approval_status = ?, final_approved_by = ? WHERE id = ?");
    $update->bind_param("sii", $status, $user_id, $request_id);
    $update->execute();
}

header("Location: request.php");
exit;
?>
