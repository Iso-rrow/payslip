<?php
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../database/connect.php';

use Dompdf\Dompdf;

// Define function BEFORE using it
function getPayslipDefaults() {
    $jsonPath = __DIR__ . '/../pages/get_payslip_defaults.php';
    ob_start();
    include $jsonPath;
    $json = ob_get_clean();
    return json_decode($json, true);
}

$employeeId = $_GET['employee_id'] ?? null;
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;

if (!$employeeId || !$startDate || !$endDate) {
    echo "Missing parameters.";
    exit;
}

// Fetch employee data and total time
$query = "
    SELECT 
        e.first_name, e.last_name, e.salary_rate,
        SUM(a.total_time) AS total_hours
    FROM attendance a
    JOIN employees e ON a.employee_id = e.employee_id
    WHERE a.employee_id = ?
      AND a.date BETWEEN ? AND ?
    GROUP BY e.employee_id
";


$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $employeeId, $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "No records found.";
    exit;
}

// Compute time and salary
$total_time = round($data['total_hours'], 2);
$salary_rate = $data['salary_rate'];

// Semi-monthly logic setup
$monthly_work_hours = 8 * 22; // Assuming 22 working days at 8 hours/day
$monthly_salary = $salary_rate * $monthly_work_hours;
$semi_monthly_salary = $monthly_salary / 2;

// PhilHealth computation (Employee share only: 4% x 0.5)
$philhealth = ($monthly_salary * 0.04) * 0.5;

// Basic salary is pro-rated if employee did not work full semi-monthly hours
$expected_hours_in_semi_month = $monthly_work_hours / 2; // 88 hours
$basic_salary = ($total_time / $expected_hours_in_semi_month) * $semi_monthly_salary;

// Gross salary with allowance, bonus, and overtime
$gross_salary = $basic_salary + $allowance + $bonus + $overtime_pay;
$total_deductions = $withholding_tax + $sss + $pagibig + $philhealth + $late_deduction + $absent_deduction;
$net_salary = $gross_salary - $total_deductions;

// Salary computation
$gross_salary = ($total_time * $salary_rate) + $allowance + $bonus + $overtime_pay;
$total_deductions = $withholding_tax + $sss + $pagibig + $philhealth + $late_deduction + $absent_deduction;
$net_salary = $gross_salary - $total_deductions;


$html = '
<style>
    body { font-family: Arial, sans-serif; }
    .header { text-align: center; font-size: 18px; font-weight: bold; }
    .section-title { font-weight: bold; background-color: #e0f7fa; }
    .total { font-weight: bold; background-color: #f1f8e9; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
</style>

<div class="header">ZHELEXION<br>PAY SLIP</div><br>
<p><strong>Employee:</strong> ' . htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) . '</p>
<p><strong>Pay Period:</strong> ' . htmlspecialchars($startDate) . ' to ' . htmlspecialchars($endDate) . '</p>
<p><strong>ID Number:</strong> ' . htmlspecialchars($employeeId) . '</p>
<p><strong>Pay Cycle:</strong> Semi-monthly</p>

<table>
    <tr class="section-title">
        <th>Earnings</th>
        <th>Amount</th>
        <th>Deductions</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>Basic Salary</td>
        <td>' . number_format($basic_salary, 2) . '</td>
        <td>Withholding Tax</td>
        <td>' . number_format($withholding_tax, 2) . '</td>
    </tr>
    <tr>
        <td>Allowance</td>
        <td>' . number_format($allowance, 2) . '</td>
        <td>SSS</td>
        <td>' . number_format($sss, 2) . '</td>
    </tr>
    <tr>
        <td>Overtime</td>
        <td>' . number_format($overtime_pay, 2) . '</td>
        <td>Pag-IBIG</td>
        <td>' . number_format($pagibig, 2) . '</td>
    </tr>
    <tr>
        <td>Bonus</td>
        <td>' . number_format($bonus, 2) . '</td>
        <td>PhilHealth</td>
        <td>' . number_format($philhealth, 2) . '</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td>Late Deduction</td>
        <td>' . number_format($late_deduction, 2) . '</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td>Absent Deduction</td>
        <td>' . number_format($absent_deduction, 2) . '</td>
    </tr>
    <tr class="total">
        <td>Gross Earnings</td>
        <td>' . number_format($gross_salary, 2) . '</td>
        <td>Total Deductions</td>
        <td>' . number_format($total_deductions, 2) . '</td>
    </tr>
    <tr class="total">
        <td colspan="3">Net Salary</td>
        <td><strong>' . number_format($net_salary, 2) . '</strong></td>
    </tr>
</table>
';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF
$filename = 'Payslip_' . $data['first_name'] . '_' . $data['last_name'] . '.pdf';
$dompdf->stream($filename, ['Attachment' => 1]);
?>
