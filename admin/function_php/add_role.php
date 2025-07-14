<?php
include __DIR__ . '/../../database/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = trim($_POST['role_name']);
    $dept_id = (int)$_POST['department_id'];
    if ($role !== '' && $dept_id > 0) {
        $stmt = $conn->prepare("INSERT INTO roles (department_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $dept_id, $role);
        $stmt->execute();
    }
}
header("Location: ../?pages=department&success=role");

exit;
