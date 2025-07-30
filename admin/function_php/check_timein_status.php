<?php
session_start();
require __DIR__ . '/../../database/connect.php';

$employee_id = $_SESSION['employee_id'];
$today = date('Y-m-d');

$stmt = $conn->prepare("SELECT id FROM attendance WHERE employee_id = ? AND date = ?");
$stmt->bind_param("is", $employee_id, $today);
$stmt->execute();
$stmt->store_result();

echo ($stmt->num_rows > 0) ? 'yes' : 'no';
?>
