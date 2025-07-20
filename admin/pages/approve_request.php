<?php 
session_start();
include __DIR__ . '/../../database/connect.php'; 

if (!isset($_SESSION['employee_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$request_id = $_POST['request_id'];
$action = $_POST['action']; 
$user_id = $_SESSION['employee_id'];

$status = ($action === 'approve') ? 'Approved' : 'Declined';

$stmt = $conn->prepare("SELECT e.department, e.position, r.name AS role_name, r.can_approve 
                        FROM employees e 
                        LEFT JOIN roles r ON e.position = r.id 
                        WHERE e.employee_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$approver = $result->fetch_assoc();

// Fetch current approval status of the request
$reqCheck = $conn->prepare("SELECT department_approval_status FROM file_requests WHERE id = ?");
$reqCheck->bind_param("i", $request_id);
$reqCheck->execute();
$reqResult = $reqCheck->get_result();
$request = $reqResult->fetch_assoc();

if ($approver && $approver['can_approve'] && $request['department_approval_status'] === 'Pending') {
    // Department-level approval or decline
    $update = $conn->prepare("UPDATE file_requests SET department_approval_status = ?, approved_by = ? WHERE id = ?");
    $update->bind_param("sii", $status, $user_id, $request_id);
    $update->execute();

} elseif ($request['department_approval_status'] === 'Approved') {
    // Final approval or decline by HR
    $checkHR = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $checkHR->bind_param("i", $user_id);
    $checkHR->execute();
    $hrResult = $checkHR->get_result();
    $hrUser = $hrResult->fetch_assoc();

    if ($hrUser && strtolower($hrUser['role']) === 'hr') {
        $update = $conn->prepare("UPDATE file_requests SET final_approval_status = ?, final_approved_by = ? WHERE id = ?");
        $update->bind_param("sii", $status, $user_id, $request_id);
        $update->execute();

        $overallStatus = ($status === 'Approved') ? 'Approved' : 'Declined';
        $updateStatus = $conn->prepare("UPDATE file_requests SET status = ? WHERE id = ?");
        $updateStatus->bind_param("si", $overallStatus, $request_id);
        $updateStatus->execute();

    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Only HR can give final approval or decline.']);
        exit;
    }

} else {
    http_response_code(403);
    echo json_encode(['error' => 'You are not authorized to take this action.']);
    exit;
}

header("Location:../index.php?pages=request");
exit;
?>
