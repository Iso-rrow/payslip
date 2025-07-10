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
            /////////////////////////////////////////////////////// -->

        <div class="d-flex justify-content-end " data-kt-employee-table-toolbar="base">

            <button type="button" class="btn btn-light-primary btn-sm me-3" data-bs-toggle="tooltip"
                title="Coming Soon">
                <i class="ki-duotone ki-filter fs-6"><span class="path1"></span><span class="path2"></span></i>
                Filter
            </button>


            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addEmployeeModal" title="Add New Employee">
                <i class="ki-duotone ki-plus fs-6"></i> Add Employee
            </button>
        </div>
    </div>
</div>









<!-- TABLE -->


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
    <table id="kt_datatable_example_2" class="table table-sm  table-row-dashed fs-7 gy-3">
        <thead>
            <tr class="text-start text-gray-500 text-center fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_datatable_example_2 .form-check-input" value="1" />
                    </div>
                </th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Account Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            <tr class="text-start text-center fs-7 gs-0 my-2">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_datatable_example_2 .form-check-input" value="1" />



                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</div>



<!-- EDIT -->

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="col-md-12">
                        <label class="form-label">Employee ID</label>
                        <input type="text" class="form-control" id="edit_employee_id" name="employee_id" readonly>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="hr">HR</option>
                            <option value="employee">Employee</option>
                        </select>
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





<script src="/payslip/admin/function_js/getUsers.js"></script>