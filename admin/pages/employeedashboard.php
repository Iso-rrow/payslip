<?php
$pages = "";

if (!isset($_SESSION['employee_id'])) {
    header('Location: ../../authentication/login.php');
    exit;
}

include __DIR__ . '/../../database/connect.php'; 

$employee_id = $_SESSION['employee_id'];
$user_name = $_SESSION['user_name'] ?? 'User';


$cred_stmt = $conn->prepare("SELECT name, email FROM users WHERE employee_id = ?");
$cred_stmt->bind_param("i", $employee_id);
$cred_stmt->execute();
$credentials = $cred_stmt->get_result()->fetch_assoc();


$att_stmt = $conn->prepare("SELECT date, time_in, time_out, total_time FROM attendance WHERE employee_id = ? ORDER BY date DESC");
$att_stmt->bind_param("i", $employee_id);
$att_stmt->execute();
$att_result = $att_stmt->get_result();
?>



<!-- Toolbar Header -->
<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap mb-5">
    <div class="page-title d-flex flex-column me-5 py-2">
        <span class="text-dark fw-bold fs-3 mb-0"><?php echo htmlspecialchars($pages); ?></span>
    </div>

    <div class="d-flex flex-stack mb-5 gap-4">
        <div class="d-flex justify-content-end" data-kt-employee-table-toolbar="base">
            <!-- <button type="button" class="btn btn-light-primary btn-sm me-3" title="Filter">
                <i class="ki-duotone ki-filter fs-6"></i> Filter
            </button> -->
            <button type="button" class="btn btn-primary  btn-sm me-3" data-bs-toggle="modal"
                data-bs-target="#requestModal">
                <i class="ki-duotone ki-tablet-book fs-6"><span class="path1"></span><span class="path2"></span></i>
                Request File
            </button>
        </div>
    </div>
</div>


<?php if (isset($_SESSION['message']) && isset($_GET['request']) && $_GET['request'] === 'true'): ?>
    <div class="alert alert-info text-center">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="container py-5">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="mb-3 text-primary">Welcome, to your Dashboard</h3>

            <h5 class="text-muted">Your Profile</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><i class="bi bi-person-fill me-2"></i><strong>Name:</strong> <?= htmlspecialchars($credentials['name']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="bi bi-envelope-fill me-2"></i><strong>Email:</strong> <?= htmlspecialchars($credentials['email']) ?></p>
                </div>
            </div>
        </div>
    </div>

   <div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Attendance Records</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Total Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $att_result->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-3"><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= date('h:i A', strtotime($row['time_in'])) ?></td>
                            <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                            <td><?= htmlspecialchars($row['total_time']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- Request Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="admin/pages/submit_request.php">
      <div class="modal-header">
        <h5 class="modal-title" id="requestModalLabel">Request a File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
        <div class="mb-3">
          <label for="request_type" class="form-label">Request Type</label>
          <select class="form-select" name="request_type" required>
            <option value="" selected disabled>-- Select Type --</option>
            <option value="Payslip">Payslip</option>
            <option value="Vacation Leave">Vacation Leave</option>
            <option value="Overtime">Overtime</option>
            <option value="Early Out">Early Out</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Certificate of Employment">Certificate of Employment</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="notes" class="form-label">Additional Notes</label>
          <textarea class="form-control" name="notes" rows="3" placeholder="Optional..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit Request</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
