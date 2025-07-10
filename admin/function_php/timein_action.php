<?php
session_start();
require __DIR__ . '/../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$lat = $data['lat'];
$lon = $data['lon'];
$action = $data['action'] ?? 'in';
$employee_id = $_SESSION['employee_id'];

if ($action === 'in') {
    // Insert into time_logs
    $stmt = $conn->prepare("INSERT INTO time_logs (employee_id, time_in, latitude, longitude, date) VALUES (?, NOW(), ?, ?, CURDATE())");
    $stmt->bind_param("idd", $employee_id, $lat, $lon);
    $stmt->execute();

    // Get employee name (assumes you have an 'employees' table)
    $nameStmt = $conn->prepare("SELECT name FROM employees WHERE id = ?");
    $nameStmt->bind_param("i", $employee_id);
    $nameStmt->execute();
    $nameResult = $nameStmt->get_result();
    $employee = $nameResult->fetch_assoc();
    $employeeName = $employee['name'];

    // Insert into attendance table
    $insertAttendance = $conn->prepare("INSERT INTO attendance (employee_id, name, time_in, date) VALUES (?, ?, NOW(), CURDATE())");
    $insertAttendance->bind_param("is", $employee_id, $employeeName);
    $insertAttendance->execute();

    echo "Time-in successful!";
}

elseif ($action === 'out') {
    $stmt = $conn->prepare("UPDATE time_logs SET time_out = NOW() WHERE employee_id = ? AND date = CURDATE() AND time_out IS NULL ORDER BY time_in DESC LIMIT 1");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();

    if ($stmt->affected_rows) {
        // Update time_out and total_time in attendance table
        $updateAttendance = $conn->prepare("
            UPDATE attendance 
            SET time_out = NOW(), total_time = TIMEDIFF(NOW(), time_in)
            WHERE employee_id = ? AND date = CURDATE()
        ");
            
        $updateAttendance->bind_param("i", $employee_id);
        $updateAttendance->execute();

        echo "Time-out successful!";
    } else {
        echo "No matching time-in found for today.";
    }
}

?>
