<?php
include __DIR__ . '/../../database/connect.php'; 
$pages = "Employee Management";

$employees = [];

$departmentFilter = '';
$params = [];

$selectedDepartment = $_GET['department'] ?? 'All Departments';

if (!empty($selectedDepartment) && $selectedDepartment !== 'All Departments') {
    $departmentFilter = " WHERE department = ? ";
    $params[] = $selectedDepartment;
}


$sql = "SELECT * FROM employees" . $departmentFilter . " ORDER BY last_name ASC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param("s", ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}
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
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-5 position-absolute ms-6"><span class="path1"></span><span
                    class="path2"></span></i>
            <input type="text" data-kt-employee-table-filter="search"
                class="form-control form-control-sm form-control-solid w-250px ps-15" placeholder="Search Employee" />
        </div>

        <!--/////////////////////Filter Button/////////////////////
            ///////////////////////////////////////////////////////-->

        <div class="d-flex justify-content-end " data-kt-employee-table-toolbar="base">
            <!--begin::Filter-->
            <button type="button" class="btn btn-light-primary btn-sm me-3" data-bs-toggle="tooltip"
                title="Coming Soon">
                <i class="ki-duotone ki-filter fs-6"><span class="path1"></span><span class="path2"></span></i>
                Filter
            </button>

            <!--///////////////////// Add Customer Button/////////////////////
            ///////////////////////////////////////////////////////////// -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addEmployeeModal" title="Add New Employee">
                <i class="ki-duotone ki-plus-circle fs-6">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i> Add Employee
            </button>
        </div>
    </div>
</div>





<!--/////////////////////Add Employee Modal/////////////////////
    ////////////////////////////////////////////////////////////-->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form id="addEmployeeForm" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Employee ID</label>
                            <input name="employee_id" id="employeeId" class="form-control" readonly required>
                        </div>
                        <!--/////////////////////Personal Info/////////////////////
                            ////////////////////////////////////////////////////// -->
                        <div class="col-md-6">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="img_name" accept="image/*" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="tel" name="contact_number" class="form-control" required>
                        </div>
                        <!--/////////////////////Additional Info/////////////////////-->
                        <div class="col-md-6">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" class="form-select" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sex</label>
                            <select name="sex" class="form-select" required>
                                <option value="" disabled selected>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Citizenship</label>
                            <input name="citizenship" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" name="height" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Religion</label>
                            <input name="religion" class="form-control" required>
                        </div>
                        <!--/////////////////////Employment Info/////////////////////
                            ////////////////////////////////////////////////////////-->
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select name="department" id="departmentSelect" class="form-select" required>
                                <option value="" disabled selected>Select Department</option>
                                <?php
                                    $departments = $conn->query("SELECT id, name FROM departments");
                                    while ($dept = $departments->fetch_assoc()):
                                ?>
                                <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Position / Role</label>
                            <select name="position" id="roleSelect" class="form-select" required>
                                <option value="" disabled selected>Select Role</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Hired</label>
                            <input type="date" name="hire_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Scheduled Time In</label>
                            <input type="time" name="scheduled_time_in" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Scheduled Time Out</label>
                            <input type="time" name="scheduled_time_out" class="form-control" required>
                        </div>
                        <!--/////////////////////Government IDs/////////////////////
                            ///////////////////////////////////////////////////////-->
                        <div class="col-md-6">
                            <label class="form-label">SSS Number</label>
                            <input name="sss_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PhilHealth Number</label>
                            <input name="philhealth_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pag-IBIG MID Number</label>
                            <input name="pagibig_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">TIN</label>
                            <input name="tin_number" class="form-control" required>
                        </div>

                        <!--/////////////////////Payroll Info/////////////////////
                            /////////////////////////////////////////////////////-->
                        <div class="col-md-6">
                            <label class="form-label">Salary Rate</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" name="salary_rate" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select id="empPaymentMethod" name="payment_method" class="form-select" required>
                                <option value="" disabled selected>Select Method</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Check">Check</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-none" id="bankDetails">
                            <label class="form-label">Bank Name</label>
                            <input name="bank_name" class="form-control">
                        </div>
                        <div class="col-md-6 d-none" id="bankAccount">
                            <label class="form-label">Bank Account No.</label>
                            <input name="bank_account" class="form-control">
                        </div>

                        <!--/////////////////////Address & Emergency Contact/////////////////////
                            ////////////////////////////////////////////////////////////////////-->
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact Name</label>
                            <input name="emergency_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact No.</label>
                            <input name="emergency_phone" class="form-control">
                        </div>
                        <!--/////////////////////Document Upload/////////////////////-->
                        <div class="col-md-12">
                            <label class="form-label">Resume</label>
                            <input type="file" name="documents[]" class="form-control" multiple>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">SSS File</label>
                            <input type="file" name="sss_file" class="form-control" accept=".pdf,.jpg,.png,.jpeg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PhilHealth File</label>
                            <input type="file" name="philhealth_file" class="form-control"
                                accept=".pdf,.jpg,.png,.jpeg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pag-IBIG File</label>
                            <input type="file" name="pagibig_file" class="form-control" accept=".pdf,.jpg,.png,.jpeg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Drug Test Result</label>
                            <input type="file" name="drugtest_file" class="form-control" accept=".pdf,.jpg,.png,.jpeg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NBI Clearance</label>
                            <input type="file" name="nbi_file" class="form-control" accept=".pdf,.jpg,.png,.jpeg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Medical Certificate</label>
                            <input type="file" name="medical_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>





<!--/////////////////////Datatable/////////////////////
    //////////////////////////////////////////////////-->

<!--begin::Group actions-->
<div class="d-flex justify-content-end align-items-center d-none" data-kt-employee-table-toolbar="selected">
    <div class="fw-bold me-5">
        <span class="me-2 fs-7" data-kt-employee-table-select="selected_count"></span> Selected
    </div>

    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
        Selection Action
    </button>
</div>
<!--end::Group actions-->

<div class="container-fluid">
    
    <table id="kt_datatable_example_1" class="table table-sm table-row-dashed fs-7 gy-3">
        <thead>
            <tr class="text-start text-gray-500 text-center fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                               data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                    </div>
                </th>
                <th>Auto ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Hire Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-semibold">
        <?php foreach ($employees as $employee): ?>
            <tr class="text-start text-center fs-7 gs-0 my-2">
                <td class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" value="<?= $employee['employee_id'] ?>" />
                    </div>
                </td>
                    
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEmployeeForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">

                    <!-- Hidden ID Fields -->
                    <input type="hidden" name="employee_id" id="edit_employee_id">
                    <input type="text" id="edit_auto_employee_id" name="auto_employee_id" class="form-control mb-3"
                        readonly>

                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <img id="edit_employee_img" src="/payslip/uploads/employees/default.jpg"
                            class="rounded-circle border" style="width: 130px; height: 130px; object-fit: cover;"
                            alt="Employee Image">


                        <input type="hidden" name="existing_image_name" id="existing_image_name">
                        <input type="file" name="employee_image" id="employee_image_input" class="form-control mt-2"
                            accept="image/*">
                    </div>
                    <!-- Personal Info -->
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="first_name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="last_name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="edit_contact_number" name="contact_number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Civil Status</label>
                        <select name="civil_status" id="edit_civil_status" class="form-select">
                            <option value="" disabled selected>Select Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sex</label>
                        <select name="sex" id="edit_sex" class="form-select">
                            <option value="" disabled selected>Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Citizenship</label>
                        <input name="citizenship" id="edit_citizenship" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" name="height" id="edit_height" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" id="edit_weight" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <input name="religion" id="edit_religion" class="form-control">
                    </div>
                    <!-- Employment Info -->
                    <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <select id="edit_department" name="department" class="form-select" required>
                            <option value="" disabled selected>Select Department</option>
                            <?php
                                $departments = $conn->query("SELECT id, name FROM departments");
                                while ($dept = $departments->fetch_assoc()):
                            ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Position / Role</label>
                        <select id="edit_position" name="position" class="form-select" required>
                            <option value="" disabled selected>Select Role</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date Hired</label>
                        <input type="date" name="hire_date" id="edit_hire_date"  class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Scheduled Time In</label>
                        <input type="time" class="form-control" id="edit_scheduled_time_in" name="scheduled_time_in">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Scheduled Time Out</label>
                        <input type="time" class="form-control" id="edit_scheduled_time_out" name="scheduled_time_out">
                    </div>

                    <!-- Government IDs -->
                    <div class="col-md-6">
                        <label class="form-label">SSS Number</label>
                        <input type="text" class="form-control" id="edit_sss_number" name="sss_number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">PhilHealth Number</label>
                        <input type="text" class="form-control" id="edit_philhealth_number" name="philhealth_number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pag-IBIG MID Number</label>
                        <input type="text" class="form-control" id="edit_pagibig_number" name="pagibig_number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">TIN</label>
                        <input type="text" class="form-control" id="edit_tin_number" name="tin_number">
                    </div>

                    <!-- Payroll -->
                    <div class="col-md-6">
                        <label class="form-label">Salary Rate (₱)</label>
                        <input type="number" class="form-control" id="edit_salary_rate" name="salary_rate" step="0.01">
                    </div>
                    <div class="col-md-6">
                    <label class="form-label">Payment Method</label>
                    <select id="edit_payment_method" name="payment_method" class="form-select" required>
                        <option value="" disabled>Select Method</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Check">Check</option>
                    </select>
                    </div>
                    <!-- Address -->
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="edit_address" name="address"></textarea>
                    </div>

                    <!-- Emergency -->
                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact Name</label>
                        <input type="text" class="form-control" id="edit_emergency_name" name="emergency_name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact No.</label>
                        <input type="text" class="form-control" id="edit_emergency_phone" name="emergency_phone">
                    </div>

                    <!-- Uploaded Documents -->
                    <div class="col-md-12">
                        <label class="form-label">Resume</label>
                        <div id="edit_documents_preview" class="border p-2 bg-light rounded">
                            <em>No documents uploaded.</em>
                        </div>
                        <input type="file" name="documents[]" id="edit_documents_input" class="form-control mt-2"
                            multiple>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">SSS Document</label>
                        <div id="edit_sss_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="sss_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">PhilHealth Document</label>
                        <div id="edit_philhealth_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="philhealth_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Pag-IBIG Document</label>
                        <div id="edit_pagibig_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="pagibig_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Drug Test Result</label>
                        <div id="edit_drugtest_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="drugtest_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">NBI Clearance</label>
                        <div id="edit_nbi_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="nbi_file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Medical Certificate</label>
                        <div id="edit_medical_file_preview" class="mb-2 text-muted"><em>No file uploaded.</em></div>
                        <input type="file" name="medical_file" class="form-control">
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ---------------------------------------------- View Employee Modal------------------------------------------------
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="viewEmployeeModalLabel">View Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="d-flex justify-content-center mb-4">
                    <img id="view_employee_img" src="" alt="employee Picture"
                    style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #dee2e6;">

                </div>
            

            <div class="modal-body row g-3">
                 Auto-generated fields (disabled inputs) -->
<!-- <div class="col-md-6">
                    <label class="form-label">Employee ID</label>
                    <input type="text" class="form-control" id="view_auto_employee_id" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" id="view_first_name" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="view_last_name" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" id="view_email" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="view_contact_number" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Civil Status</label>
                    <input type="text" class="form-control" id="view_civil_status" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sex</label>
                    <input type="text" class="form-control" id="view_sex" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Citizenship</label>
                    <input type="text" class="form-control" id="view_citizenship" disabled>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Height (cm)</label>
                    <input type="text" class="form-control" id="view_height" disabled>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Weight (kg)</label>
                    <input type="text" class="form-control" id="view_weight" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Religion</label>
                    <input type="text" class="form-control" id="view_religion" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" id="view_department" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Position / Role</label>
                    <input type="text" class="form-control" id="view_position" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date Hired</label>
                    <input type="text" class="form-control" id="view_hire_date" disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label">SSS Number</label>
                    <input type="text" class="form-control" id="view_sss_number" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PhilHealth Number</label>
                    <input type="text" class="form-control" id="view_philhealth_number" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pag-IBIG MID Number</label>
                    <input type="text" class="form-control" id="view_pagibig_number" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">TIN</label>
                    <input type="text" class="form-control" id="view_tin_number" disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Salary Rate (₱)</label>
                    <input type="text" class="form-control" id="view_salary_rate" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Payment Method</label>
                    <input type="text" class="form-control" id="view_payment_method" disabled>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" id="view_address" disabled></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control" id="view_emergency_name" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact No.</label>
                    <input type="text" class="form-control" id="view_emergency_phone" disabled>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Uploaded Documents</label>
                    <div id="view_documents_preview" class="border p-2 bg-light rounded"> -->
<!-- Append document links here -->
<!-- </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div> -->


<?php include 'modals/view_employee_modal.php'; ?>

<!--/////////////////////Scripts/////////////////////
    ////////////////////////////////////////////////-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/payslip/admin/function_js/addEmployeeInfo.js"></script>
<script src="/payslip/admin/function_js/getEmployee.js"></script>




<script>
document.getElementById('empPaymentMethod').addEventListener('change', function() {
    const show = this.value === 'Bank Transfer';
    document.getElementById('bankDetails').classList.toggle('d-none', !show);
    document.getElementById('bankAccount').classList.toggle('d-none', !show);
});
</script>



<!-- EMPLOYEE ID AUTO GENERATED -->


<script>
function generateEmployeeID() {
    const year = new Date().getFullYear();
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    return `EMP-${year} - ${randomNum}`;
}

const addEmployeeModal = document.querySelector('#addEmployeeModal');
addEmployeeModal.addEventListener('shown.bs.modal', () => {
    document.querySelector('#employeeId').value = generateEmployeeID();
});



</script>