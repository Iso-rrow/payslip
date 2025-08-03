<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/../../database/connect.php';

// Check login
if (!isset($_SESSION['employee_id'])) {
    echo json_encode(['success' => false, 'message' => 'Employee not logged in.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$lat = $data['lat'];
$lon = $data['lon'];
$action = $data['action'] ?? 'in';
$employee_id = $_SESSION['employee_id'];

// Fetch employee schedule and info
$schedStmt = $conn->prepare("SELECT scheduled_time_in, scheduled_time_out, salary_rate, first_name, last_name FROM employees WHERE employee_id = ?");
$schedStmt->bind_param("i", $employee_id);
$schedStmt->execute();
$schedResult = $schedStmt->get_result();
$schedData = $schedResult->fetch_assoc(); 

if (!$schedData) {
    echo json_encode(['success' => false, 'message' => 'Employee schedule not found.']);
    exit;
}

date_default_timezone_set('Asia/Manila');

$scheduledTimeIn = DateTime::createFromFormat('H:i:s', $schedData['scheduled_time_in'], new DateTimeZone('Asia/Manila'));
$scheduledTimeIn->setDate(date('Y'), date('m'), date('d'));

$scheduledTimeOut = DateTime::createFromFormat('H:i:s', $schedData['scheduled_time_out'], new DateTimeZone('Asia/Manila'));
$scheduledTimeOut->setDate(date('Y'), date('m'), date('d'));

$salaryRate = $schedData['salary_rate'];
$employeeName = $schedData['first_name'] . ' ' . $schedData['last_name'];
$currentDate = (new DateTime())->format('Y-m-d');

if ($action === 'in') {
    
    $checkStmt = $conn->prepare("SELECT id FROM attendance WHERE employee_id = ? AND date = ?");
    $checkStmt->bind_param("is", $employee_id, $currentDate);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => "You can't time in because you already timed in today."]);
        exit;
    }
    
    
    // Evaluate lateness
    $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $diffMinutes = ($now->getTimestamp() - $scheduledTimeIn->getTimestamp()) / 60;
    $lateStatus = 'On Time';
    $lateMinutes = 0;
    $deduction = 0;

    if ($diffMinutes < -1) {
        $lateStatus = 'Early In';
    } elseif ($diffMinutes >= 5) {
        $lateStatus = 'Late';
        $lateMinutes = round($diffMinutes);
        $deduction = round(($lateMinutes / 60) * $salaryRate, 2);
    }


    $insert = $conn->prepare("
        INSERT INTO attendance 
        (employee_id, name, time_in, date, late_status, late_minutes, deduction, remarks)
        VALUES (?, ?, NOW(), ?, ?, ?, ?, ?)
    ");
    $remarks = ($lateStatus === 'Late') ? 'Late' : 'Present';
    $insert->bind_param("isssdds", $employee_id, $employeeName, $currentDate, $lateStatus, $lateMinutes, $deduction, $remarks);
    $insert->execute();

    echo json_encode([
        'success' => true,
        'message' => "Time-in successful! Status: $lateStatus" . ($deduction > 0 ? " | Deduction: ₱$deduction" : "")
    ]);
    exit;
}

if ($action === 'out') {
    
    $fetchStmt = $conn->prepare("SELECT time_in, late_minutes, deduction, remarks FROM attendance WHERE employee_id = ? AND date = ?");
    $fetchStmt->bind_param("is", $employee_id, $currentDate);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    $record = $result->fetch_assoc();

    if (!$record || !$record['time_in']) {
        echo json_encode(['success' => false, 'message' => "You haven't timed in yet."]);
        exit;
    }

    $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $underTimeStatus = '';
    $underTimeDeduction = 0;
    $minutesUnder = 0;

    if ($now < $scheduledTimeOut) {
        $minutesUnder = ($scheduledTimeOut->getTimestamp() - $now->getTimestamp()) / 60;
        $underTimeStatus = 'Under Time';
        $underTimeDeduction = round(($minutesUnder / 60) * $salaryRate, 2);
    }

    
    $timeIn = new DateTime($record['time_in']);
    $totalTime = $timeIn->diff($now)->format('%H:%I:%S');

    
    $remarks = 'Present';
    if ($record['late_minutes'] > 0 && $underTimeDeduction > 0) {
        $remarks = 'Late & Under Time';
    } elseif ($record['late_minutes'] > 0) {
        $remarks = 'Late';
    } elseif ($underTimeDeduction > 0) {
        $remarks = 'Under Time';
    }

    $update = $conn->prepare("
        UPDATE attendance 
        SET time_out = NOW(), total_time = ?, undertime_status = ?, undertime_deduction = ?, remarks = ?
        WHERE employee_id = ? AND date = ?
    ");
    $update->bind_param("ssdsss", $totalTime, $underTimeStatus, $underTimeDeduction, $remarks, $employee_id, $currentDate);
    $update->execute();

    echo json_encode([
        'success' => true,
        'message' => "Time-out successful!" . ($underTimeDeduction > 0 ? " Status: $underTimeStatus | Deduction: ₱$underTimeDeduction" : "")
    ]);
    exit;
}


echo json_encode(['success' => false, 'message' => 'Invalid action or request.']);
exit;
?>
