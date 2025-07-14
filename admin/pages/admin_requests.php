<?php
session_start();
include '../../database/connect.php';

$query = "
    SELECT r.id, r.employee_id, r.request_type, r.notes, r.request_date, r.status, u.name 
    FROM file_requests r 
    JOIN users u ON r.employee_id = u.employee_id 
    ORDER BY r.request_date DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Employee File Requests</h2>

    <table class="table table-bordered table-hover mt-4">
        <thead class="table-light">
            <tr>
                <th>Employee Name</th>
                <th>Request Type</th>
                <th>Notes</th>
                <th>Date Requested</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['request_type']); ?></td>
                <td><?php echo htmlspecialchars($row['notes']); ?></td>
                <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <form method="POST" action="update_request_status.php" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status" class="form-select form-select-sm d-inline w-auto" required>
                            <option disabled selected>Change</option>
                            <option value="Approved">Approve</option>
                            <option value="Denied">Deny</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
