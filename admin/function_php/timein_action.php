<?php
session_start();
require __DIR__ . '/../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$lat = $data['lat'];
$lon = $data['lon'];
$action = $data['action'] ?? 'in';
$employee_id = $_SESSION['employee_id'];

if ($action === 'in') {
    $stmt = $conn->prepare("INSERT INTO time_logs (employee_id, time_in, latitude, longitude, date) VALUES (?, NOW(), ?, ?, CURDATE())");
    $stmt->bind_param("idd", $employee_id, $lat, $lon);
    $stmt->execute();
    echo "Time-in successful!";
} elseif ($action === 'out') {
    $stmt = $conn->prepare("UPDATE time_logs SET time_out = NOW() WHERE employee_id = ? AND date = CURDATE() AND time_out IS NULL ORDER BY time_in DESC LIMIT 1");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    echo $stmt->affected_rows ? "Time-out successful!" : "No matching time-in found for today.";
} else {
    echo "Invalid action.";
}
?>
