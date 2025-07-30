<?php
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];


    $stmt_date = $conn->prepare("SELECT employee_id, date FROM attendance WHERE id = ?");
    $stmt_date->bind_param("i", $id);
    $stmt_date->execute();
    $stmt_date->bind_result($employee_id, $attendance_date);
    $stmt_date->fetch();
    $stmt_date->close();

    // Combine the original date with the updated time input
    $datetime_in = $time_in ? $attendance_date . ' ' . $time_in . ':00' : null;
    $datetime_out = $time_out ? $attendance_date . ' ' . $time_out . ':00' : null;

    // Update attendance time_in and time_out even if null
    $stmt = $conn->prepare("UPDATE attendance SET time_in = ?, time_out = ? WHERE id = ?");
    $stmt->bind_param("ssi", $datetime_in, $datetime_out, $id);

    if ($stmt->execute()) {
        $total_time = "00:00:00";
        $remarks = "Absent";

        if ($datetime_in && $datetime_out) {
            $start = new DateTime($datetime_in);
            $end = new DateTime($datetime_out);
            $interval = $start->diff($end);
            $total_time = $interval->format('%H:%I:%S');

            $hours = (int)$interval->format('%H');
            $minutes = (int)$interval->format('%i');

            if ($hours < 8 || ($hours == 8 && $minutes < 0)) {
                $remarks = "Undertime";
            } else {
                $remarks = "Present";
            }
        }

        // Insert or update attendance record (preserving date)
        $att_stmt = $conn->prepare("
            INSERT INTO attendance (employee_id, date, time_in, time_out, total_time, remarks)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                time_in = VALUES(time_in),
                time_out = VALUES(time_out),
                total_time = VALUES(total_time),
                remarks = VALUES(remarks)
        ");
        $att_stmt->bind_param("isssss", $employee_id, $attendance_date, $datetime_in, $datetime_out, $total_time, $remarks);
        $att_stmt->execute();

        echo "Updated successfully with remark: $remarks";
    } else {
        echo "Update failed.";
    }
}
?>
