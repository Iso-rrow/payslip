<?php
include '../../database/connect.php';
$dateToday = date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM attendance WHERE date = ?");
$stmt->execute([$dateToday]);
$rows = $stmt->fetchAll();
?>

<h2>Attendance</h2>
<p>Attendance Table for <?php echo date('F d, Y'); ?></p>

<table id="attendanceTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Total Time</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($rows): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '' ?></td>
                    <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '' ?></td>
                    <td><?= $row['total_time'] ?? '—' ?></td>
                    <td><?= date('F d, Y', strtotime($row['date'])) ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No data available in table</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    
    $(document).ready(function() {
        $('#attendanceTable').DataTable();
    });
</script>
<script>
    setInterval(() => {
        location.reload();
    }, 10000); 
</script>