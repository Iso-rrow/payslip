<?php
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../database/connect.php';

use Dompdf\Dompdf;

// Load global default values from a config file
function getPayslipDefaults() {
    $jsonPath = __DIR__ . '/../pages/get_payslip_defaults.php';
    ob_start();
    include $jsonPath;
    $json = ob_get_clean();
    return json_decode($json, true);
}

// Get data
$data = json_decode(file_get_contents("php://input"), true);
$startDate = $data['start_date'] ?? null;
$endDate = $data['end_date'] ?? null;
$employees = $data['employees'] ?? [];

if (!$startDate || !$endDate || empty($employees)) {
    echo "Missing or invalid parameters.";
    exit;
}

$defaults = getPayslipDefaults();

$html = '
<style>
    body { font-family: Arial, sans-serif; }
    .header { text-align: center; font-size: 18px; font-weight: bold; }
    .section-title { font-weight: bold; background-color: #e0f7fa; }
    .total { font-weight: bold; background-color: #f1f8e9; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 50px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
</style>
<div class="header">ZHELEXION PAYSLIP REPORT</div>
<p><strong>Pay Period:</strong> ' . htmlspecialchars($startDate) . ' to ' . htmlspecialchars($endDate) . '</p>
';

// Function to count working days between two dates (Mon-Fri only)
function countWorkingDays($startDate, $endDate) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

    $workdays = 0;
    foreach ($period as $day) {
        $weekday = $day->format('N');
        if ($weekday < 6) { // Mon–Fri
            $workdays++;
        }
    }
    return $workdays;
}

foreach ($employees as $emp) {
    $employeeId      = $emp['employee_id'];
    $name            = htmlspecialchars($emp['name'] ?? '');
    $total_hours     = floatval($emp['total_hours'] ?? 0);
    $salary_rate     = floatval($emp['salary_rate'] ?? 0);
    $allowance       = floatval($emp['allowance'] ?? 0);
    $bonus           = floatval($emp['bonus'] ?? 0);
    $overtime_pay    = floatval($emp['overtime_pay'] ?? 0);
    $withholding_tax = floatval($emp['withholding_tax'] ?? 0);
    $sss             = floatval($emp['sss'] ?? 0);
    $pagibig         = floatval($emp['pagibig'] ?? 0);
    $philhealth      = floatval($emp['philhealth'] ?? 0);
    $late            = floatval($emp['late_deduction'] ?? 0);
    $absent          = floatval($emp['absent_deduction'] ?? 0);
    $basic_salary    = floatval($emp['basic_salary'] ?? 0);
    $gross_salary    = floatval($emp['gross_earnings'] ?? 0);
    $total_deductions= $withholding_tax + $sss + $pagibig + $philhealth + $late + $absent;
    $net_salary      = floatval($emp['net_pay'] ?? ($gross_salary - $total_deductions));


    $html .= '
    <hr>
    <p><strong>Employee:</strong> ' . $name . '</p>

    <p><strong>ID Number:</strong> ' . htmlspecialchars($employeeId) . '</p>
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
            <td>' . number_format($late, 2) . '</td>
        </tr>
        <tr>
            <td></td><td></td>
            <td>Absent Deduction</td>
            <td>' . number_format($absent, 2) . '</td>
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
    </table>';
}

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Dynamic filename
$firstEmployeeName = isset($employees[0]['name']) ? preg_replace('/\s+/', '_', $employees[0]['name']) : 'Employee';
if (count($employees) === 1) {
    $firstEmployeeName = preg_replace('/\s+/', '_', $employees[0]['name']);
    $filename = $firstEmployeeName . '_Payslip_' . $startDate . '_to_' . $endDate . '.pdf';
} else {
    $filename = 'Employees_Payslip_' . $startDate . '_to_' . $endDate . '.pdf';
}

// Output
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=$filename");
echo $dompdf->output();
exit;
?>
