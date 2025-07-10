<?php
require __DIR__ . '/../../vendor/autoload.php'; // path to autoload.php from Composer
include __DIR__ . '/../../database/connect.php';

use Dompdf\Dompdf;

$employeeId = $_GET['employee_id'] ?? null;
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;

if (!$employeeId || !$startDate || !$endDate) {
    echo "Missing parameters.";
    exit;
}

$query = "
    SELECT 
        e.first_name, e.last_name, e.salary_rate,
        SUM(TIMESTAMPDIFF(SECOND, t.time_in, t.time_out)) AS total_seconds
    FROM time_logs t
    JOIN employees e ON t.employee_id = e.employee_id
    WHERE t.employee_id = ?
      AND t.date BETWEEN ? AND ?
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

// Compute salary
$total_hours = round($data['total_seconds'] / 3600, 2);
$salary_rate = $data['salary_rate'];
$gross_salary = $total_hours * $salary_rate;

// Deductions
$withholding_tax = $gross_salary * 0.10;
$sss = $gross_salary * 0.045;
$pagibig = $gross_salary * 0.02;
$philhealth = $gross_salary * 0.03;
$total_deductions = $withholding_tax + $sss + $pagibig + $philhealth;
$net_salary = $gross_salary - $total_deductions;

// HTML content for PDF
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
<p><strong>Employee:</strong> ' . $data['first_name'] . ' ' . $data['last_name'] . '</p>
<p><strong>Pay Period:</strong> ' . $startDate . ' to ' . $endDate . '</p>
<p><strong>ID Number:</strong> ' . $employeeId . '</p>
<p><strong>Pay Cycle:</strong> Bi-weekly</p>
<p><strong>Bank Details:</strong> -</p>
<p><strong>Tax Number:</strong> -</p>

<table>
    <tr class="section-title">
        <th>Earnings</th>
        <th>Amount</th>
        <th>Deductions</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>Basic Salary</td>
        <td>' . number_format($gross_salary, 2) . '</td>
        <td>Withholding Tax</td>
        <td>' . number_format($withholding_tax, 2) . '</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td>SSS</td>
        <td>' . number_format($sss, 2) . '</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td>Pag-IBIG</td>
        <td>' . number_format($pagibig, 2) . '</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td>PhilHealth</td>
        <td>' . number_format($philhealth, 2) . '</td>
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
$dompdf->stream($filename, ['Attachment' => 1]); // 1 = download, 0 = open in browser
?>
