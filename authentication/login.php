<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_log("Session: " . print_r($_SESSION, true));



header('Content-Type: application/json');

include '../database/connect.php'; // Adjust path as needed

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Sanitize inputs
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

// Fetch user by email (update table/col names as needed)
$stmt = $conn->prepare("SELECT id, employee_id, name, email, password, role, must_change_password FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $user = $result->fetch_assoc()) {
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Store info in session
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['employee_id'] = $user['employee_id'];
        $_SESSION['user_name']  = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role']  = $user['role'];
        
        // If you want to force a password change, check here
        if ($user['must_change_password']) {
            echo json_encode(['success' => true, 'must_change_password' => true]);
            exit;
        }

        echo json_encode(['success' => true]);
        exit;
    }
}

// Login failed
echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
exit;
