<?php
session_start();
require_once '../function_php/db.php';


if (!isset($_SESSION['employee_id'])) {
    header('Location: login.html');
    exit;
}

$employee_id = $_SESSION['employee_id'];

$stmt = $pdo->prepare("SELECT * FROM time_logs WHERE employee_id = ? ORDER BY date DESC, time_in DESC");
$stmt->execute([$employee_id]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Attendance Logs</title>
</head>
<body>
    <h2>Attendance Logs for <?php echo $employee_id; ?></h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
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
                <td><?= $log['date'] ?></td>
                <td><?= $log['time_in'] ?></td>
                <td><?= $log['time_out'] ?? '—' ?></td>
                <td><?= $log['latitude'] ?></td>
                <td><?= $log['longitude'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <br>
    <a href="timein.php">Back to Time-In</a>
</body>
</html>
