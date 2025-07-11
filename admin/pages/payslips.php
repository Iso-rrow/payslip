<?php
$pages = "Employee Payslip";

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
            <button type="button" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addDepartmentModal" title="Add New Department">
                <i class="ki-duotone ki-plus-circle fs-6"><span class="path1"></span><span class="path2"></span></i>
                Generate Payslip
            </button>
            <!--///////////////////// Add Customer Button/////////////////////
            ///////////////////////////////////////////////////////////// -->   
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
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Gross Pay</th>
                <th>Type of Employee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            <tr class="text-start text-center fs-7 gs-0 my-2">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_datatable_example_2 .form-check-input" value="1" />
                            
                        <!------------------------------------------------Beginning of Employee Profile-------------------------------------------------->
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Gross Pay</th>
                        <th>Type of Employee</th>
                        <th>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewpayslip" title="View Payslip">
                                <i class="ki-duotone ki-eye fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i> View
                            </button>
                        </th>
                        <!------------------------------------------------End of Employee profile-------------------------------------------------->
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</div>
