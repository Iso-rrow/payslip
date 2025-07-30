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
                class="form-control form-control-sm form-control-solid w-250px ps-15" placeholder="Search Employee" />
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
            <?php
                $query = "
                    SELECT 
                        e.employee_id,
                        e.first_name,
                        e.last_name,
                        d.name AS department_name,
                        r.name AS position_name,
                        e.salary_rate
                    FROM 
                        employees e
                    LEFT JOIN departments d ON e.department = d.id
                    LEFT JOIN roles r ON e.position = r.id
                ";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) :
                ?>
            <tr class="text-start text-center fs-7 gs-0 my-2">
                <td class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" />
                    </div>
                </td>
                <td><?= htmlspecialchars($row['employee_id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['department_name']) ?></td>
                <td><?= htmlspecialchars($row['position_name']) ?></td>
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
                        <input type="text" id="dateRangePicker" class="form-control" placeholder="Select date range"
                            required>
                        <input type="hidden" name="start_date">
                        <input type="hidden" name="end_date">
                    </div>
                </div>
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-info btn-sm" id="fetchPayslipData">Generate Payslip
                        Data</button>
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
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="showYearlyTax">
                                <label class="form-check-label" for="showYearlyTax">
                                    Show Yearly Withholding Tax
                                </label>
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
                                <input type="number" class="form-control" name="absent_deduction"
                                    id="absent_deduction" />
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
    sss: 0,
    pagibig: 0,
    philhealth: 0,
    withholding_tax: 0,
    late_deduction: 0,
    absent_deduction: 0,
    allowance: 0,
    overtime_pay: 0,
    bonus: 0
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
document.addEventListener("DOMContentLoaded", function() {

    const generateBtn = document.getElementById("generateSelectedPayslips");
    if (generateBtn) {
        generateBtn.addEventListener("click", () => {
            selectedEmployees = [];
            document.querySelectorAll('#kt_datatable_example_1 tbody input[type="checkbox"]:checked')
                .forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const employeeId = row.cells[1]?.textContent.trim();
                    const name = row.cells[2]?.textContent.trim();
                    if (employeeId && name) {
                        selectedEmployees.push({
                            employee_id: employeeId,
                            name
                        });
                    }
                });

            if (selectedEmployees.length === 0) {
                alert("Please select at least one employee.");
                return;
            }

            document.querySelector("#employee-payslip-forms").innerHTML = "";
            document.getElementById("selected-employees-list").innerHTML =
                '<strong>Selected Employees:</strong> ' + selectedEmployees.map(emp => emp.name).join(
                    ', ');
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
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                employee_ids: selectedEmployees.map(e => e.employee_id),
                start_date,
                end_date
            })
        })
        .then(async res => {
            const text = await res.text();
            try {
                const json = JSON.parse(text);
                console.log("JSON response:", json);
                return json;
            } catch (err) {
                console.error("Failed to parse JSON. Raw response:", text);
                throw err;
            }
        })
        .then(data => {
            if (data.status === "success") {
                const container = document.getElementById("employee-payslip-forms");
                container.innerHTML = "";

                data.employees.forEach(emp => {
                    const t = (val, empVal = null) => {
                        if (empVal !== null && !isNaN(empVal)) return parseFloat(empVal).toFixed(2);
                        return parseFloat(payslipDefaults[val] || 0).toFixed(2);
                    };

                    const grossEarnings = parseFloat(emp.basic_salary) 
                        + parseFloat(t('allowance', emp.allowance))
                        + parseFloat(t('bonus', emp.bonus))
                        + parseFloat(t('overtime_pay', emp.overtime_pay));

                    const totalDeductions = parseFloat(t('sss', emp.sss))
                        + parseFloat(t('pagibig', emp.pagibig))
                        + parseFloat(t('philhealth', emp.philhealth))
                        + parseFloat(t('withholding_tax', emp.withholding_tax))
                        + parseFloat(t('late_deduction', emp.late_deduction))
                        + parseFloat(t('absent_deduction', emp.absent_deduction));

                    const netSalary = grossEarnings - totalDeductions;

                    const yearlyTax = (parseFloat(t('withholding_tax', emp.withholding_tax)) * 12).toFixed(2);

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
                            <div class="row">
                                <div class="col-md-4 mb-2"><strong>Hours Worked:</strong> ${emp.total_hours}</div>
                                <div class="col-md-4 mb-2"><strong>Salary Rate:</strong> ₱${parseFloat(emp.salary_rate).toFixed(2)}</div>
                                <div class="col-md-4 mb-2"><strong>SSS:</strong> ₱${t('sss', emp.sss)}</div>
                                <div class="col-md-4 mb-2"><strong>Pag-IBIG:</strong> ₱${t('pagibig', emp.pagibig)}</div>
                                <div class="col-md-4 mb-2"><strong>PhilHealth:</strong> ₱${t('philhealth', emp.philhealth)}</div>
                                <div class="col-md-4 mb-2"><strong>Monthly Withholding Tax:</strong> ₱${t('withholding_tax', emp.withholding_tax)}</div>
                                <div class="col-md-4 mb-2 yearly-tax" style="display: none;"><strong>Yearly Withholding Tax:</strong> ₱${yearlyTax}</div>
                                <div class="col-md-4 mb-2"><strong>Late Deduction:</strong> ₱${t('late_deduction', emp.late_deduction)}</div>
                                <div class="col-md-4 mb-2"><strong>Absent Deduction:</strong> ₱${t('absent_deduction', emp.absent_deduction)}</div>
                                <div class="col-md-4 mb-2"><strong>Allowance:</strong> ₱${t('allowance', emp.allowance)}</div>
                                <div class="col-md-4 mb-2"><strong>Overtime Pay:</strong> ₱${t('overtime_pay', emp.overtime_pay)}</div>
                                <div class="col-md-4 mb-2"><strong>Bonus:</strong> ₱${t('bonus', emp.bonus)}</div>
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

                    container.insertAdjacentHTML('beforeend', template);
                });

                // Toggle Yearly Tax visibility
                const taxToggle = document.getElementById('toggleYearlyTax');
                if (taxToggle) {
                    taxToggle.addEventListener('change', () => {
                        document.querySelectorAll('.yearly-tax').forEach(div => {
                            div.style.display = taxToggle.checked ? 'block' : 'none';
                        });
                    });
                }
            } else {
                alert("Failed to fetch payslip data.");
            }
        });
    });
}



    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        onClose: function(selectedDates) {
            if (selectedDates.length === 2) {
                const [start, end] = selectedDates;
                document.querySelector("input[name='start_date']").value = flatpickr.formatDate(
                    start, "Y-m-d");
                document.querySelector("input[name='end_date']").value = flatpickr.formatDate(end,
                    "Y-m-d");
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
                headers: {
                    'Content-Type': 'application/json'
                },
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
                    const val = el ? parseFloat(el.textContent.replace(/[^0-9.-]+/g, "")) :
                        0;
                    return val;
                };

                const total_hours = getNumber("Hours Worked:");
                const salary_rate = getNumber("Salary Rate:");
                const gross = salary_rate;
                const allowance = getNumber("Allowance:");
                const overtime_pay = getNumber("Overtime Pay:");
                const bonus = getNumber("Bonus:");
                const tax = getNumber("Withholding Tax:");
                const sss = getNumber("SSS:");
                const pagibig = getNumber("Pag-IBIG:");
                const philhealth = getNumber("PhilHealth:");
                const late = getNumber("Late Deduction:");
                const absent = getNumber("Absent Deduction:");

                const total_pay = gross + allowance + overtime_pay + bonus - (tax + sss +
                    pagibig + philhealth + late + absent);

                payslips.push({
                employee_id: emp.employee_id,
                start_date,
                end_date,
                total_hours,
                salary_rate,
                bonus,
                allowance,
                overtime_pay,
                withholding_tax: tax,
                late_deduction: late,
                absent_deduction: absent,
                total_pay
            });
            });

            fetch("/payslip/admin/pages/save_payslip_data.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        payslips
                    })
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

    const type = btn.getAttribute('data-type'); // 'pdf' or 'excel'
    const start_date = document.querySelector("input[name='start_date']").value;
    const end_date = document.querySelector("input[name='end_date']").value;

    if (!start_date || !end_date) {
        alert("Please select a date range first.");
        return;
    }

    if (!selectedEmployees.length) {
        alert("Please select at least one employee.");
        return;
    }

    // Step 1: Get accurate computed payslip data from backend
    fetch('/payslip/admin/pages/get_payslip_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            start_date,
            end_date,
            employee_ids: selectedEmployees.map(emp => emp.employee_id)
        })
    })
        .then(res => res.json())
        .then(data => {
            if (!data || data.status !== 'success' || !data.employees) {
                throw new Error("Invalid or missing payroll data from server.");
            }

            const exportData = {
                start_date,
                end_date,
                employees: data.employees
            };

            // Step 2: Send that accurate data to PDF or Excel generator
            const exportUrl = type === 'pdf'
                ? '/payslip/admin/pages/export_payslip_pdf.php'
                : '/payslip/admin/pages/export_payslip_excel.php';

            return fetch(exportUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(exportData)
            });
        })
        .then(async res => {
    const blob = await res.blob();
    let filename = 'payslip.' + (type === 'pdf' ? 'pdf' : 'xlsx');

    // Try to extract filename from headers
    const disposition = res.headers.get('Content-Disposition');
    const match = disposition && disposition.match(/filename="?([^"]+)"?/);
    if (match && match[1]) {
        filename = match[1];
    }

    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    URL.revokeObjectURL(url);
    a.remove();
})
});


</script>