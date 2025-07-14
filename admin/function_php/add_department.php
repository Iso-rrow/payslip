<?php
include __DIR__ . '/../../database/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['department_name']);
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}

header("Location: ../?pages=department&success=department");
exit;
