<?php
include __DIR__ . '/../../database/connect.php';
$pages = "Attendance";

$dateToday = date('Y-m-d');
$query = "
    SELECT
        t.id,
        t.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS name,
        t.time_in,
        t.time_out,
        TIMEDIFF(t.time_out, t.time_in) AS total_time,
        t.date,
        e.salary_rate
    FROM time_logs t
    JOIN employees e ON t.employee_id = e.employee_id
    WHERE t.date = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $dateToday);
$stmt->execute();
$result = $stmt->get_result();
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
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '' ?></td>
                    <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '' ?></td>
                    <td><?= $row['total_time'] ?? '—' ?></td>
                    <td><?= date('F d, Y', strtotime($row['date'])) ?></td>
                    <td>
                        <button class="btn btn-sm btn-info payslip-btn" data-id="<?= $row['id'] ?>" data-employee="<?= $row['employee_id'] ?>">Payslip</button>
                        <button class="btn btn-sm btn-primary edit-btn" data-id="<?= $row['id'] ?>">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
                    </td>

                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            
        <?php endif; ?>
    </tbody>
</table>

 <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Attendance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label>Time In</label>
            <input type="time" name="time_in" id="edit-time-in" class="form-control">
          </div>
          <div class="mb-3">
            <label>Time Out</label>
            <input type="time" name="time_out" id="edit-time-out" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Payslip Modal -->
<div class="modal fade" id="payslipModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="payslipForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generate Payslip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" id="payslip-employee-id">
        <div class="mb-3">
          <label>From Date</label>
          <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>To Date</label>
          <input type="date" name="end_date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Generate</button>
      </div>
    </form>
  </div>
</div>

       




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    // $(document).ready(function() {
    //     $('#attendanceTable').DataTable();
    // });
 
    // setInterval(() => {
    //     location.reload();
    // }, 10000);

    $(document).on('click', '.payslip-btn', function () {
  const employeeId = $(this).data('employee');
  $('#payslip-employee-id').val(employeeId);

  // Bootstrap 5 Modal
  const payslipModal = new bootstrap.Modal(document.getElementById('payslipModal'));
  payslipModal.show();
});

$('#payslipForm').on('submit', function (e) {
  e.preventDefault();
  const employeeId = $('#payslip-employee-id').val();
  const startDate = $(this).find('[name="start_date"]').val();
  const endDate = $(this).find('[name="end_date"]').val();

  const url = `admin/function_php/generate_payslip.php?employee_id=${employeeId}&start_date=${startDate}&end_date=${endDate}`;
  window.open(url, '_blank');
});



    $(document).ready(function () {
  $('#attendanceTable').DataTable();

    // Edit
  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    $('#edit-id').val(id);
    

    $('#editModal').modal('show');
  });

 
  $('#editForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: 'admin/function_php/update_attendance.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        alert(response);
        location.reload();
      }
    });
  });

  // Delete 
  $(document).on('click', '.delete-btn', function () {
    if (!confirm("Are you sure you want to delete this record?")) return;

    const id = $(this).data('id');
    $.ajax({
      url: 'admin/function_php/delete_attendance.php',
      method: 'POST',
      data: { id: id },
      success: function (response) {
        alert(response);
        location.reload();
      }
    });
  });
});
</script>
