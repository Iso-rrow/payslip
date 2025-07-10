
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="viewEmployeeModalLabel">View Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row g-3">
        
        <div class="d-flex justify-content-center mb-4">
          <img id="view_employee_img" src="/payslip/uploads/employees/default.jpg" alt="Employee Picture"
            onerror="this.src='/payslip/uploads/employees/default.jpg'"
            style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #dee2e6;">
        </div>

        
        <div class="col-md-6">
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
          <label class="form-label">Scheduled Time In</label>
          <input type="text" class="form-control" id="view_scheduled_time_in" disabled>
        </div>
        <div class="col-md-6">
          <label class="form-label">Scheduled Time Out</label>
          <input type="text" class="form-control" id="view_scheduled_time_out" disabled>
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
          <textarea class="form-control" id="view_address" rows="2" disabled></textarea>
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
          <label class="form-label">Resume</label>
          <div id="view_documents_preview" class="border p-2 bg-light rounded">
          </div>
        <div class="col-md-12">
            <label class="form-label">SSS Document</label>
            <div id="view_sss_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>

            <div class="col-md-12">
            <label class="form-label">PhilHealth Document</label>
            <div id="view_philhealth_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>

            <div class="col-md-12">
            <label class="form-label">Pag-IBIG Document</label>
            <div id="view_pagibig_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>

            <div class="col-md-12">
            <label class="form-label">Drug Test Result</label>
            <div id="view_drugtest_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>

            <div class="col-md-12">
            <label class="form-label">NBI Clearance</label>
            <div id="view_nbi_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>

            <div class="col-md-12">
            <label class="form-label">Medical Certificate</label>
            <div id="view_medical_file_preview" class="text-muted"><em>No file uploaded.</em></div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
