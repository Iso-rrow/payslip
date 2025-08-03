<?php
$pages = "File Request";

include __DIR__ . '/../../database/connect.php';
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
                class="form-control form-control-sm form-control-solid w-250px ps-15" placeholder="Search Employee"/>
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
            <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDepartmentModal" title="Add New Role">
                <i class="ki-duotone ki-plus-circle fs-6">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i> Add Role
            </button> -->
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
    <table id="kt_datatable_example_1" class="table table-sm  table-row-dashed fs-7 gy-3">
        <thead>
            <tr class="text-start text-gray-500 text-center fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                    </div>
                </th>
                <th>Auto ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Department</th>
                <th>Role</th>
                <th>Notes</th> 
                <th>Date</th> 
                <th>Status</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            <?php 
            $query = "
                SELECT fr.id, fr.request_type, fr.notes, fr.request_date, fr.status,
                fr.department_approval_status, fr.final_approval_status,
                e.first_name, e.last_name,
                d.name AS department_name,
                r.name AS role_name
            FROM file_requests fr
            JOIN employees e ON fr.employee_id = e.employee_id
            LEFT JOIN departments d ON e.department = d.id
            LEFT JOIN roles r ON e.position = r.id
            ORDER BY fr.id DESC
            ";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <tr class="text-center align-middle">
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" value="<?= $row['id'] ?>" />
                        </div>
                    </td>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['request_type']) ?></td>
                    <td><?= htmlspecialchars($row['department_name']) ?></td>
                    <td><?= htmlspecialchars($row['role_name']) ?></td>
                    <td><?= htmlspecialchars($row['notes']) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($row['request_date']))) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <?php if ($row['department_approval_status'] === 'Pending'): ?>
                            <form action="admin/pages/approve_request.php" method="POST" class="d-inline">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="admin/pages/approve_request.php" method="POST" class="d-inline">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="decline">
                                <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                            </form>
                        <?php elseif ($row['department_approval_status'] === 'Approved' && $row['final_approval_status'] === 'Pending'): ?>
                            <form action="admin/pages/approve_request.php" method="POST" class="d-inline">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-sm btn-primary">Final Conformation</button>
                            </form>
                            <form action="admin/pages/approve_request.php" method="POST" class="d-inline">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="decline">
                                <button type="submit" class="btn btn-sm btn-warning">Final Decline</button>
                            </form>
                        <?php else: ?>
                            <span class="badge bg-light">
                                <?= htmlspecialchars($row['department_approval_status'] . ' / ' . $row['final_approval_status']) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php
                    endwhile;
                else:
                ?>
                    <tr class="text-center">
                        <td colspan="9">No requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
    </table>
</div>