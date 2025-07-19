<?php
$pages = "Employee Payslip";
include __DIR__ . '/../../database/connect.php';
?>
<!-- Toolbar Header -->
<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack flex-wrap mb-5">
    <div class="page-title d-flex flex-column me-5 py-2">
        <span class="text-dark fw-bold fs-3 mb-0"><?php echo htmlspecialchars($pages); ?></span>
    </div>
    <div class="d-flex flex-stack mb-5 gap-4">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-5 position-absolute ms-6"></i>
            <input type="text" data-kt-employee-table-filter="search"
                   class="form-control form-control-sm form-control-solid w-250px ps-15" placeholder="Search Employee"/>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="tooltip" title="Coming Soon">
                <i class="ki-duotone ki-filter fs-6"></i> Filter
            </button>
            <button type="button" class="btn btn-light-danger btn-sm" id="editPayslipFormat">
                <i class="ki-duotone ki-edit fs-6"></i> Edit Payslip Template
            </button>
        </div>
    </div>
</div>


<div class="container-fluid">
    <table id="kt_datatable_example_1" class="table table-sm table-row-dashed fs-7 gy-3">
        <thead>
        <tr class="text-start text-gray-500 text-center fw-bold fs-7 text-uppercase gs-0">
            <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                           data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1"/>
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
        <?php
        $query = "SELECT employee_id, first_name, last_name, department, position, salary_rate FROM employees";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()):
        ?>
            <tr class="text-start text-center fs-7 gs-0 my-2">
                <td class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" />
                    </div>
                </td>
                <td><?= htmlspecialchars($row['employee_id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['position']) ?></td>
                <td>₱<?= number_format($row['salary_rate'], 2) ?></td>
                <td>Regular</td>
                <td><button class="btn btn-sm btn-info" disabled>View</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Button to trigger bulk generation -->
<div class="text-end my-4">
  <button class="btn btn-primary btn-sm" id="generateSelectedPayslips">
    Generate for Selected
  </button>
</div>

<!-- Payslip Modal -->
<div class="modal fade" id="payslipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="payslipForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Payslip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="selected-employees-list" class="mb-4"></div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Date Range:</label>
                        <input type="text" id="dateRangePicker" class="form-control" placeholder="Select date range" required>
                        <input type="hidden" name="start_date">
                        <input type="hidden" name="end_date">
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="button" class="btn btn-info btn-sm" id="fetchPayslipData">Generate Payslip Data</button>
                </div>
                <hr>
                <div id="employee-payslip-forms"></div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end gap-2 mt-3">
    <button class="btn btn-sm btn-danger export-btn" data-type="pdf">
        <i class="ki-duotone ki-file fs-6"></i> Export as PDF
    </button>
    <button class="btn btn-sm btn-success export-btn" data-type="excel">
        <i class="ki-duotone ki-file-spreadsheet fs-6"></i> Export as Excel
    </button>
</div>
        </form>
    </div>
</div>
<!-- Payslip Format Edit Modal -->
<div class="modal fade" id="editPayslipModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <form id="payslipFormatForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Payslip Default Values</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <!-- Earnings Fields -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="sss" class="form-label">SSS</label>
                <input type="number" class="form-control" name="sss" id="sss" />
              </div>
              <div class="mb-3">
                <label for="pagibig" class="form-label">Pag-IBIG</label>
                <input type="number" class="form-control" name="pagibig" id="pagibig" />
              </div>
              <div class="mb-3">
                <label for="philhealth" class="form-label">PhilHealth</label>
                <input type="number" class="form-control" name="philhealth" id="philhealth" />
              </div>
              <div class="mb-3">
                <label for="withholding_tax" class="form-label">Withholding Tax</label>
                <input type="number" class="form-control" name="withholding_tax" id="withholding_tax" />
              </div>
            </div>

            <!-- Deductions Fields -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="late_deduction" class="form-label">Late Deduction</label>
                <input type="number" class="form-control" name="late_deduction" id="late_deduction" />
              </div>
              <div class="mb-3">
                <label for="absent_deduction" class="form-label">Absent Deduction</label>
                <input type="number" class="form-control" name="absent_deduction" id="absent_deduction" />
              </div>
              <div class="mb-3">
                <label for="allowance" class="form-label">Allowance</label>
                <input type="number" class="form-control" name="allowance" id="allowance" />
              </div>
              <div class="mb-3">
                <label for="overtime_pay" class="form-label">Overtime Pay</label>
                <input type="number" class="form-control" name="overtime_pay" id="overtime_pay" />
              </div>
              <div class="mb-3">
                <label for="bonus" class="form-label">Bonus</label>
                <input type="number" class="form-control" name="bonus" id="bonus" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    
    
let selectedEmployees = [];
let payslipDefaults = {
    sss: 0, pagibig: 0, philhealth: 0, withholding_tax: 0,
    late_deduction: 0, absent_deduction: 0,
    allowance: 0, overtime_pay: 0, bonus: 0
};

async function loadPayslipDefaults() {
    try {
        const res = await fetch('/payslip/admin/pages/get_payslip_defaults.php');
        payslipDefaults = await res.json();
    } catch (err) {
        console.error('Failed to load payslip defaults', err);
    }
}

loadPayslipDefaults();
document.addEventListener("DOMContentLoaded", function () {

    const generateBtn = document.getElementById("generateSelectedPayslips");
    if (generateBtn) {
        generateBtn.addEventListener("click", () => {
            selectedEmployees = [];
            document.querySelectorAll('#kt_datatable_example_1 tbody input[type="checkbox"]:checked').forEach(checkbox => {
                const row = checkbox.closest('tr');
                const employeeId = row.cells[1]?.textContent.trim();
                const name = row.cells[2]?.textContent.trim();
                if (employeeId && name) {
                    selectedEmployees.push({ employee_id: employeeId, name });
                }
            });

            if (selectedEmployees.length === 0) {
                alert("Please select at least one employee.");
                return;
            }

            document.querySelector("#employee-payslip-forms").innerHTML = "";
            document.getElementById("selected-employees-list").innerHTML = '<strong>Selected Employees:</strong> ' + selectedEmployees.map(emp => emp.name).join(', ');
            const payslipModal = document.getElementById('payslipModal');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(payslipModal);
            modalInstance.show();

        });
    }

    const fetchBtn = document.getElementById("fetchPayslipData");
    if (fetchBtn) {
        fetchBtn.addEventListener("click", async () => {
            const start_date = document.querySelector("input[name='start_date']").value;
            const end_date = document.querySelector("input[name='end_date']").value;

            await loadPayslipDefaults();

            fetch("/payslip/admin/pages/get_payslip_data.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    employee_ids: selectedEmployees.map(e => e.employee_id),
                    start_date,
                    end_date
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    const container = document.getElementById("employee-payslip-forms");
                    container.innerHTML = "";

                    data.employees.forEach(emp => {
                        const t = (val) => {
                            if (!payslipDefaults) return "0.00";
                            return parseFloat(payslipDefaults[val] || 0).toFixed(2);
                        };

                        const grossEarnings = (emp.total_hours * emp.salary_rate) + parseFloat(t('allowance')) + parseFloat(t('bonus')) + parseFloat(t('overtime_pay'));
                        const totalDeductions = parseFloat(t('sss')) + parseFloat(t('pagibig')) + parseFloat(t('philhealth')) + parseFloat(t('withholding_tax')) + parseFloat(t('late_deduction')) + parseFloat(t('absent_deduction'));
                        const netSalary = grossEarnings - totalDeductions;

                                                            const template = `
                                    <div class="border rounded p-4 mb-4 shadow bg-white">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                        <h5 class="fw-bold mb-1">Employee Payslip</h5>
                                        <small>${start_date} to ${end_date}</small>
                                        </div>
                                        <div class="text-end">
                                        <h6 class="mb-0">${emp.name}</h6>
                                        <small>ID: ${emp.employee_id}</small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="employee_id" value="${emp.employee_id}">
                                    <input type="hidden" name="total_hours" value="${emp.total_hours}">
                                    <input type="hidden" name="salary_rate" value="${emp.salary_rate}">
                                    <input type="hidden" name="sss" value="${t('sss')}">
                                    <input type="hidden" name="pagibig" value="${t('pagibig')}">
                                    <input type="hidden" name="philhealth" value="${t('philhealth')}">
                                    <input type="hidden" name="withholding_tax" value="${t('withholding_tax')}">
                                    <input type="hidden" name="late_deduction" value="${t('late_deduction')}">
                                    <input type="hidden" name="absent_deduction" value="${t('absent_deduction')}">
                                    <input type="hidden" name="allowance" value="${t('allowance')}">
                                    <input type="hidden" name="overtime_pay" value="${t('overtime_pay')}">
                                    <input type="hidden" name="bonus" value="${t('bonus')}">
                                    <div class="row">
                                        <div class="col-md-4 mb-2"><strong>Hours Worked:</strong> ${emp.total_hours}</div>
                                        <div class="col-md-4 mb-2"><strong>Salary Rate:</strong> ₱${parseFloat(emp.salary_rate).toFixed(2)}</div>
                                        <div class="col-md-4 mb-2"><strong>SSS:</strong> ₱${t('sss')}</div>
                                        <div class="col-md-4 mb-2"><strong>Pag-IBIG:</strong> ₱${t('pagibig')}</div>
                                        <div class="col-md-4 mb-2"><strong>PhilHealth:</strong> ₱${t('philhealth')}</div>
                                        <div class="col-md-4 mb-2"><strong>Withholding Tax:</strong> ₱${t('withholding_tax')}</div>
                                        <div class="col-md-4 mb-2"><strong>Late Deduction:</strong> ₱${t('late_deduction')}</div>
                                        <div class="col-md-4 mb-2"><strong>Absent Deduction:</strong> ₱${t('absent_deduction')}</div>
                                        <div class="col-md-4 mb-2"><strong>Allowance:</strong> ₱${t('allowance')}</div>
                                        <div class="col-md-4 mb-2"><strong>Overtime Pay:</strong> ₱${t('overtime_pay')}</div>
                                        <div class="col-md-4 mb-2"><strong>Bonus:</strong> ₱${t('bonus')}</div>
                                    </div>
                                    <hr>
                                    <div class="row fw-bold">
                                        <div class="col-md-4"><strong>Gross Earnings:</strong></div>
                                        <div class="col-md-8 text-end">₱${grossEarnings.toFixed(2)}</div>
                                        <div class="col-md-4"><strong>Total Deductions:</strong></div>
                                        <div class="col-md-8 text-end">₱${totalDeductions.toFixed(2)}</div>
                                        <div class="col-md-4"><strong>Net Salary:</strong></div>
                                        <div class="col-md-8 text-end text-success">₱${netSalary.toFixed(2)}</div>
                                    </div>
                                    </div>
                                    `;
                        let allHTML = '';
                        data.employees.forEach(emp => {
                        
                        allHTML += template;
                        });
                        container.innerHTML = allHTML;
                                    }); 
                                } else {
                                    alert("Failed to fetch payslip data.");
                                }
                            });
                        });;
                            }

                        flatpickr("#dateRangePicker", {
                            mode: "range",
                            dateFormat: "Y-m-d",
                            onClose: function(selectedDates) {
                                if (selectedDates.length === 2) {
                                    const [start, end] = selectedDates;
                                    document.querySelector("input[name='start_date']").value = flatpickr.formatDate(start, "Y-m-d");
                                    document.querySelector("input[name='end_date']").value = flatpickr.formatDate(end, "Y-m-d");
                                }
                            }
                        });

                const editBtn = document.getElementById('editPayslipFormat');
                if (editBtn) {
                    editBtn.addEventListener('click', async () => {
                        await loadPayslipDefaults();

                        if (!payslipDefaults || typeof payslipDefaults !== 'object') {
                            alert("Failed to load payslip defaults.");
                            return;
                        }

                        for (const key in payslipDefaults) {
                            const input = document.querySelector(`#editPayslipModal [name='${key}']`);
                            if (input) input.value = payslipDefaults[key];
                        }

                        
                        const modalElement = document.getElementById('editPayslipModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modal.show();
                    });
                }


    const payslipFormatForm = document.getElementById('payslipFormatForm');
    if (payslipFormatForm) {
        payslipFormatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = new FormData(this);
            const data = {};
            form.forEach((val, key) => data[key] = parseFloat(val) || 0);

            fetch('/payslip/admin/pages/save_payslip_defaults.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(async res => {
            if (res.status === 'success') {
                alert('Payslip defaults saved.');
                const modalEl = document.getElementById('editPayslipModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                await loadPayslipDefaults(); 
            } else {
                alert('Failed to save.');
            }
        });
        });
    }

    const payslipForm = document.getElementById('payslipForm');
    if (payslipForm) {
        payslipForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const start_date = document.querySelector("input[name='start_date']").value;
            const end_date = document.querySelector("input[name='end_date']").value;

            const payslipElements = document.querySelectorAll("#employee-payslip-forms .border");
            const payslips = [];

            selectedEmployees.forEach((emp, index) => {
                const div = payslipElements[index];
                if (!div) return;

                const getNumber = label => {
                    const el = div.querySelector(`div[data-label="${label}"]`);
                    const val = el ? parseFloat(el.textContent.replace(/[^0-9.-]+/g, "")) : 0;
                    return val;
                };


                const total_hours = getNumber("Hours Worked:");
                const salary_rate = getNumber("Salary Rate:");
                const gross = total_hours * salary_rate;
                const allowance = getNumber("Allowance:");
                const overtime_pay = getNumber("Overtime Pay:");
                const bonus = getNumber("Bonus:");
                const tax = getNumber("Withholding Tax:");
                const sss = getNumber("SSS:");
                const pagibig = getNumber("Pag-IBIG:");
                const philhealth = getNumber("PhilHealth:");
                const late = getNumber("Late Deduction:");
                const absent = getNumber("Absent Deduction:");

                const total_pay = gross + allowance + overtime_pay + bonus - (tax + sss + pagibig + philhealth + late + absent);

                payslips.push({
                    employee_id: emp.employee_id,
                    start_date,
                    end_date,
                    total_hours,
                    salary_rate,
                    total_pay
                });
            });

            fetch("/payslip/admin/pages/save_payslip_data.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ payslips })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === "success") {
                    alert("Payslips saved successfully.");
                    bootstrap.Modal.getInstance(document.getElementById('payslipModal')).hide();
                } else {
                    alert("Failed to save payslips.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error saving payslips.");
            });
        });
    }

});

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.export-btn');
        if (!btn) return;

        e.preventDefault();

        const type = btn.getAttribute('data-type'); 
        const start_date = document.querySelector("input[name='start_date']").value;
        const end_date = document.querySelector("input[name='end_date']").value;

        if (!start_date || !end_date) {
            alert("Please select a date range first.");
            return;
        }

        const payslipElements = document.querySelectorAll("#employee-payslip-forms .border");
        const exportData = {
            start_date,
            end_date,
            employees: []
        };

        selectedEmployees.forEach((emp, index) => {
            const div = payslipElements[index];
            if (!div) return;

            const getNumber = label => {
                const spans = div.querySelectorAll("span");
                for (const span of spans) {
                    if (span.textContent.includes(label)) {
                        const text = span.textContent.replace(label, "").trim();
                        return parseFloat(text.replace(/[^0-9.-]+/g, "")) || 0;
                    }
                }
                return 0;
            };
            exportData.employees.push({
                employee_id: emp.employee_id,
            name: emp.name,
            total_hours: getNumber("Hours Worked:"),
            salary_rate: getNumber("Salary Rate:"),
            allowance: getNumber("Allowance:"),
            overtime_pay: getNumber("Overtime Pay:"),
            bonus: getNumber("Bonus:"),
            tax: getNumber("Withholding Tax:"),
            sss: getNumber("SSS:"),
            pagibig: getNumber("Pag-IBIG:"),
            philhealth: getNumber("PhilHealth:"),
            late: getNumber("Late Deduction:"),
            absent: getNumber("Absent Deduction:")
        });
    });

    const exportUrl = type === 'pdf'
        ? '/payslip/admin/pages/export_payslip_pdf.php'
        : '/payslip/admin/pages/export_payslip_excel.php';

    fetch(exportUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(exportData)
    })
    .then(res => res.blob())
    .then(blob => {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `payslip.${type === 'pdf' ? 'pdf' : 'xlsx'}`;
        document.body.appendChild(a);
        a.click();
        URL.revokeObjectURL(url);
        a.remove();
    })
    .catch(err => {
        console.error(`Error exporting ${type}:`, err);
        alert(`Failed to export ${type.toUpperCase()} payslip.`);
    });
});
</script>