<?php
include __DIR__ . '/../../database/connect.php';
$pages = "Attendance";
$fromDate = $_GET['from_date'] ?? null;
$toDate = $_GET['to_date'] ?? null;
$params = [];
$conditions = [];

$query = "
    SELECT
        t.id,
        t.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS name,
        t.time_in,
        t.time_out,
        TIMEDIFF(t.time_out, t.time_in) AS total_time,
        t.date,
        e.salary_rate,
        e.img_name
    FROM time_logs t
    JOIN employees e ON t.employee_id = e.employee_id
";

// Add date condition if filter is used
if ($fromDate && $toDate) {
    $conditions[] = "DATE(t.date) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
}

// Append WHERE clause if needed
if (!empty($conditions)) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$stmt = $conn->prepare($query);

// Bind parameters if any
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // all are strings (dates)
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();


// Group data by date
$groupedData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groupedData[$row['date']][] = $row;
    }
}
?>

<h2>Attendance</h2>

<!-- Filter Form -->
<div class="card p-4 mb-4">
<form class="row g-3 align-items-end" method="GET" action="?">
    <input type="hidden" name="pages" value="attendance">

    <div class="col-md-3">
        <label for="fromDate" class="form-label">From Date</label>
        <input type="date" id="fromDate" name="from_date" class="form-control" value="<?= $_GET['from_date'] ?? '' ?>">
    </div>
    <div class="col-md-3">
        <label for="toDate" class="form-label">To Date</label>
        <input type="date" id="toDate" name="to_date" class="form-control" value="<?= $_GET['to_date'] ?? '' ?>">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Filter</button>
        <button type="reset" class="btn btn-secondary ms-2">Reset</button>
    </div>
</form>
</div>

<!-- Attendance Tables Grouped by Date -->
<?php if (!empty($groupedData)): ?>
    <?php foreach ($groupedData as $date => $records): ?>
        <div class="card mb-5">
            <div class="card-header  bg-light mt-3">
                <h5 class="mb-0">Attendance Table for <?= date('F d, Y', strtotime($date)) ?></h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered text-center m-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Profile</th>
                            <th>Employee Name</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Total Time</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $row): ?>
                            <tr>
                                <td>
                                    <div class="symbol symbol-25px mt-1">
                                        <img src="<?= htmlspecialchars($row['img_name'] ?? '/payslip/uploads/employees/default.jpg') ?>"
                                            alt="Profile" class="rounded-circle"
                                            style="width: 25px; height: 25px; object-fit: cover;">
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '' ?></td>
                                <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '' ?></td>
                                <td><?= $row['total_time'] ?? '—' ?></td>
                                <td><?= date('F d, Y', strtotime($row['date'])) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info payslip-btn"
                                            data-id="<?= $row['id'] ?>"
                                            data-employee="<?= $row['employee_id'] ?>">Payslip</button>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="<?= $row['id'] ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center text-muted">No attendance records found.</p>
<?php endif; ?>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Attendance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" id="payslip-employee-id">

        <!-- Date Range Picker -->
        <div class="mb-3">
          <label>Date Range:</label>
          <input type="text" id="dateRangePicker" class="form-control" placeholder="Select date range" required>
          <input type="hidden" name="start_date">
          <input type="hidden" name="end_date">
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Generate</button>
      </div>
    </form>
  </div>
</div>



<!-- JS Section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>


  document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#dateRangePicker", {
      mode: "range",
      dateFormat: "Y-m-d",
      onClose: function (selectedDates) {
        if (selectedDates.length === 2) {
          const [start, end] = selectedDates;
          document.querySelector("input[name='start_date']").value = flatpickr.formatDate(start, "Y-m-d");
          document.querySelector("input[name='end_date']").value = flatpickr.formatDate(end, "Y-m-d");
        }
      }
    });
  });





$(document).on('click', '.payslip-btn', function () {
    const employeeId = $(this).data('employee');
    $('#payslip-employee-id').val(employeeId);
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
</script>
