<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

$stmt = $conn->prepare("SELECT id, employee_id, name, email, password, role, must_change_password FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id']     = $user['id'];
        $_SESSION['employee_id'] = $user['employee_id'];
        $_SESSION['user_name']   = $user['name'];
        $_SESSION['user_email']  = $user['email'];
        $_SESSION['user_role']   = $user['role'];

        // if ($user['must_change_password']) {
        //     echo json_encode(['success' => true, 'must_change_password' => true]);
        //     exit;
        // }

        if ($user['role'] === 'admin') {
            echo json_encode(['success' => true, 'redirect' => '/payslip/admin/index.php']);
        } else {
            echo json_encode(['success' => true, 'redirect' => '/payslip/admin/?pages=employeedashboard']);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
exit;