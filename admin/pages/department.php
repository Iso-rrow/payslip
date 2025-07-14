<?php
include __DIR__ . '/../../database/connect.php'; 

$pages = "Department";

$query = "SELECT d.id AS dept_id, d.name AS department, r.name AS role
          FROM departments d
          LEFT JOIN roles r ON d.id = r.department_id
          ORDER BY d.name, r.name";

$result = $conn->query($query);

$departments = [];
while ($row = $result->fetch_assoc()) {
    $dept = $row['department'];
    $role = $row['role'];

    if (!isset($departments[$dept])) {
        $departments[$dept] = [];
    }

    if ($role) {
        $departments[$dept][] = $role;
    }
}
?>

<!-- Success Alert -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
        <?php if ($_GET['success'] === 'department'): ?>
            ✅ Department added successfully!
        <?php elseif ($_GET['success'] === 'role'): ?>
            ✅ Role added successfully!
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Toolbar Header -->
<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap mb-5">
    <div class="page-title d-flex flex-column me-5 py-2">
        <span class="text-dark fw-bold fs-3 mb-0"><?php echo htmlspecialchars($pages); ?></span>
    </div>

    <div class="d-flex flex-stack mb-5 gap-4">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-5 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" data-kt-employee-table-filter="search"
                class="form-control form-control-sm form-control-solid w-250px ps-15"
                placeholder="Search Employee" />
        </div>

        <div class="d-flex justify-content-end" data-kt-employee-table-toolbar="base">
            <button type="button" class="btn btn-light-primary btn-sm me-3" data-bs-toggle="tooltip" title="Coming Soon">
                <i class="ki-duotone ki-filter fs-6"><span class="path1"></span><span class="path2"></span></i> Filter
            </button>
            <button type="button" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                <i class="ki-duotone ki-plus-circle fs-6"><span class="path1"></span><span class="path2"></span></i> Add Department
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="ki-duotone ki-plus-circle fs-6"><span class="path1"></span><span class="path2"></span></i> Add Role
            </button>
        </div>
    </div>
</div>

<!-- Datatable -->
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
                <th>Department</th>
                <th>Roles</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            <?php foreach ($departments as $dept => $roles): ?>
                <tr class="text-center">
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <td><?= htmlspecialchars($dept) ?></td>
                    <td><?= htmlspecialchars(implode(', ', $roles)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="admin/function_php/add_department.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Department Name</label>
                    <input type="text" name="department_name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="admin/function_php/add_role.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Department</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">-- Select Department --</option>
                        <?php
                        $dept_res = $conn->query("SELECT id, name FROM departments");
                        while ($dept = $dept_res->fetch_assoc()):
                        ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label class="mt-3">Role Name</label>
                    <input type="text" name="role_name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Role</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#kt_datatable_example_1').DataTable();
    });
</script>
