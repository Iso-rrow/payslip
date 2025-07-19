<?php
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../database/connect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get default values
function getPayslipDefaults() {
    $jsonPath = __DIR__ . '/../pages/get_payslip_defaults.php';
    ob_start();
    include $jsonPath;
    $json = ob_get_clean();
    return json_decode($json, true);
}

error_reporting(0);
ini_set('display_errors', 0);
ob_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['employees'])) {
    http_response_code(400);
    echo "Invalid or missing data.";
    exit;
}

$defaults = getPayslipDefaults();
extract(array_map('floatval', $defaults)); // load values like allowance, bonus, sss, etc.

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Excel Headers
$sheet->fromArray([
    'Employee ID', 'Name', 'Start Date', 'End Date',
    'Basic Salary', 'Allowance', 'Overtime Pay', 'Bonus',
    'Gross Pay', 'SSS', 'PhilHealth', 'Pag-IBIG', 'Withholding Tax',
    'Late Deduction', 'Absent Deduction', 'Net Pay'
], NULL, 'A1');

$row = 2;
foreach ($data['employees'] as $emp) {
    $employee_id = $emp['employee_id'];
    $name = $emp['name'];
    $startDate = $data['start_date'];
    $endDate = $data['end_date'];

    // Get total worked hours and salary_rate from DB
    $stmt = $conn->prepare("
        SELECT e.salary_rate, SUM(TIMESTAMPDIFF(SECOND, t.time_in, t.time_out)) AS total_seconds
        FROM time_logs t
        JOIN employees e ON t.employee_id = e.employee_id
        WHERE t.employee_id = ? AND t.date BETWEEN ? AND ?
        GROUP BY e.employee_id
    ");
    $stmt->bind_param("iss", $employee_id, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowData = $result->fetch_assoc();

    $salary_rate = isset($rowData['salary_rate']) ? floatval($rowData['salary_rate']) : 0;
    $total_hours = isset($rowData['total_seconds']) ? round($rowData['total_seconds'] / 3600, 2) : 0;
    $basic_salary = $total_hours * $salary_rate;

    // Use defaults
    $gross = $basic_salary + $allowance + $overtime_pay + $bonus;
    $deductions = $withholding_tax + $sss + $philhealth + $pagibig + $late_deduction + $absent_deduction;
    $net = $gross - $deductions;

    $sheet->setCellValue("A{$row}", $employee_id);
    $sheet->setCellValue("B{$row}", $name);
    $sheet->setCellValue("C{$row}", $startDate);
    $sheet->setCellValue("D{$row}", $endDate);
    $sheet->setCellValue("E{$row}", $basic_salary);
    $sheet->setCellValue("F{$row}", $allowance);
    $sheet->setCellValue("G{$row}", $overtime_pay);
    $sheet->setCellValue("H{$row}", $bonus);
    $sheet->setCellValue("I{$row}", $gross);
    $sheet->setCellValue("J{$row}", $sss);
    $sheet->setCellValue("K{$row}", $philhealth);
    $sheet->setCellValue("L{$row}", $pagibig);
    $sheet->setCellValue("M{$row}", $withholding_tax);
    $sheet->setCellValue("N{$row}", $late_deduction);
    $sheet->setCellValue("O{$row}", $absent_deduction);
    $sheet->setCellValue("P{$row}", $net);
    $row++;
}

foreach (range('A', 'P') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="payslip.xlsx"');
header('Cache-Control: max-age=0');

ob_end_clean();
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
