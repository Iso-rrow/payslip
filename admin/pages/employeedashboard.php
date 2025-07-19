<?php
$pages = "Employee Time in";

session_start();
if (!isset($_SESSION['employee_id'])) {
header('Location: /payslip/authentication/login.php');
}
include __DIR__ . '/../../database/connect.php'; 


$employee_id = $_SESSION['employee_id'];
$user_name = $_SESSION['user_name'] ?? 'User';


// Fetch credentials
$cred_stmt = $conn->prepare("SELECT name, email FROM users WHERE employee_id = ?");
$cred_stmt->bind_param("i", $employee_id);
$cred_stmt->execute();
$credentials = $cred_stmt->get_result()->fetch_assoc();

// Fetch attendance
$att_stmt = $conn->prepare("SELECT date, time_in, time_out, total_time FROM attendance WHERE employee_id = ? ORDER BY date DESC");
$att_stmt->bind_param("i", $employee_id);
$att_stmt->execute();
$att_result = $att_stmt->get_result();
?>

<!-- Toolbar Header -->
<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap mb-5">
    <!-- Page Title -->
    <div class="page-title d-flex flex-column me-5 py-2">
        <span class="text-dark fw-bold fs-3 mb-0"><?php echo htmlspecialchars($pages); ?></span>
    </div>

    <!--///////////////////// Search & Toolbar Search Box/////////////////////
        /////////////////////////////////////////////////////////////////////-->
    <div class="d-flex flex-stack mb-5 gap-4">
        <div class="d-flex justify-content-end" data-kt-employee-table-toolbar="base">
            <button type="button" class="btn btn-light-primary btn-sm me-3" title="Filter">
                <i class="ki-duotone ki-filter fs-6"></i> Filter
            </button>
            <button type="button" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal"
                data-bs-target="#addDepartmentModal" title="Add New Department">
                <i class="ki-duotone ki-plus-circle fs-6"><span class="path1"></span><span class="path2"></span></i>
                Time In
            </button>
            <button type="button" class="btn btn-primary  btn-sm me-3" data-bs-toggle="modal"
                data-bs-target="#requestModal">
                <i class="ki-duotone ki-tablet-book fs-6"><span class="path1"></span><span class="path2"></span></i>
                Request File
            </button>
            <!--///////////////////// Add Customer Button/////////////////////
            ///////////////////////////////////////////////////////////// -->
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info text-center">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?></h2>

        <h3>Your Credentials:</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($credentials['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($credentials['email']); ?></p>

        <h3>Attendance Records</h3>
        <table class="table table-bordered">
            <thead>
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
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo date('F j, Y h:i A', strtotime($row['time_in'])); ?></td>
                    <td><?php echo $row['time_out']; ?></td>
                    <td><?php echo $row['total_time']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Time In / Out</h3>

        <!-- Request File Button -->
        <div style="text-align: center; margin: 20px auto;">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
            <a href="admin?pages=employeedashboard" class="btn btn-success" id="timeInButton" disabled><i
                    class="bi bi-person-workspace fs-1 me-1"></i>
                Time in</a>
            <a href="#" class="btn btn-danger " id="timeOutButton" disabled><i
                    class="bi bi-person-walking fs-1 me-1"></i>
                Time out</a>
        </div>
    </div>

    <!-- Request Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="submit_request.php">
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


    <a href="/payslip/authentication/logout.php" class="btn btn-danger hover-rotate-end">Logout</a>