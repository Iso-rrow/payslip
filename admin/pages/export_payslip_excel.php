<?php
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../database/connect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(0);
ini_set('display_errors', 0);
ob_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['employees'])) {
    http_response_code(400);
    echo "Invalid or missing data.";
    exit;
}

$startDate = $data['start_date'];
$endDate = $data['end_date'];

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
    // Make sure all values exist, defaulting to 0 if missing
    $employee_id = $emp['employee_id'];
    $name = $emp['name'];

    $basic_salary     = floatval($emp['basic_salary'] ?? 0);
    $allowance        = floatval($emp['allowance'] ?? 0);
    $overtime_pay     = floatval($emp['overtime_pay'] ?? 0);
    $bonus            = floatval($emp['bonus'] ?? 0);

    $sss              = floatval($emp['sss'] ?? 0);
    $philhealth       = floatval($emp['philhealth'] ?? 0);
    $pagibig          = floatval($emp['pagibig'] ?? 0);
    $withholding_tax  = floatval($emp['withholding_tax'] ?? 0);
    $late_deduction   = floatval($emp['late_deduction'] ?? 0);
    $absent_deduction = floatval($emp['absent_deduction'] ?? 0);

    $gross = $basic_salary + $allowance + $overtime_pay + $bonus;
    $total_deductions = $sss + $philhealth + $pagibig + $withholding_tax + $late_deduction + $absent_deduction;
    $net = $gross - $total_deductions;

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

// Autosize columns
// Autosize columns
foreach (range('A', 'P') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Determine filename
if (count($data['employees']) === 1) {
    $firstEmployeeName = preg_replace('/[^\w\-]/', '_', $data['employees'][0]['name']);
    $filename = $firstEmployeeName . '_Payslip_' . $startDate . '_to_' . $endDate . '.xlsx';
} else {
    $filename = 'Employees_Payslip_' . $startDate . '_to_' . $endDate . '.xlsx';
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

ob_end_clean();
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

