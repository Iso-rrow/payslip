<?php
session_start();
require_once '../function_php/db.php';

$stmt = $pdo->query("SELECT * FROM time_logs ORDER BY date DESC, time_in DESC");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Employee Attendance Logs</title>
</head>
<body>
    <h2>Admin Panel - Attendance Logs</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log['employee_id'] ?></td>
                <td><?= $log['date'] ?></td>
                <td><?= $log['time_in'] ?></td>
                <td><?= $log['time_out'] ?? '—' ?></td>
                <td><?= $log['latitude'] ?></td>
                <td><?= $log['longitude'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
