<?php
require '../../database/connect.php';

date_default_timezone_set('Asia/Manila');
$now = new DateTime();
$today = $now->format('Y-m-d');

// Check last run
$check = $conn->query("SELECT last_checked_date FROM auto_mark_log WHERE id = 1");
$lastDate = $check->fetch_assoc()['last_checked_date'];

if ($lastDate === $today) {
    exit("Already checked today. Absent check completed " . $now->format('H:i:s'));
}


$cutoff = new DateTime($today . ' 23:55:00');
if ($now < $cutoff) {
    exit("Too early to check for absences. Current time: " . $now->format('H:i:s'));
}


$sql = "
    SELECT employee_id, first_name, last_name, scheduled_time_in, scheduled_time_out 
    FROM employees 
    WHERE scheduled_time_in IS NOT NULL AND scheduled_time_out IS NOT NULL
";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $employeeId = $row['employee_id'];
    $name = $row['first_name'] . ' ' . $row['last_name'];

  
    $stmt = $conn->prepare("SELECT id FROM attendance WHERE employee_id = ? AND date = ?");
    $stmt->bind_param('is', $employeeId, $today);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
       
        $insert = $conn->prepare("
            INSERT INTO attendance (
                employee_id, name, time_in, time_out, total_time, date, late_status, late_minutes, deduction, undertime_status, undertime_deduction, remarks
            ) VALUES (?, ?, NULL, NULL, NULL, ?, NULL, 0, 0.00, NULL, 0.00, 'Absent')
        ");
        $insert->bind_param('iss', $employeeId, $name, $today);
        $insert->execute();
    }
    $stmt->close();
}

$update = $conn->prepare("UPDATE auto_mark_log SET last_checked_date = ? WHERE id = 1");
$update->bind_param("s", $today);
$update->execute();

echo "Absent check completed at " . $now->format('H:i:s');
?>
