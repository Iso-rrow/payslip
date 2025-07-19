<?php
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_ids = $_POST['employee_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_hours = $_POST['total_hours'];
    $salary_rate = $_POST['salary_rate'];
    $late_deduction = $_POST['late_deduction'];
    $overtime_pay = $_POST['overtime_pay'];
    $absent_deduction = $_POST['absent_deduction'];
    $bonus = $_POST['bonus'];

    for ($i = 0; $i < count($employee_ids); $i++) {
        $emp_id = $employee_ids[$i];
        $hours = floatval($total_hours[$i]);
        $rate = floatval($salary_rate[$i]);
        $late = floatval($late_deduction[$i]);
        $ot = floatval($overtime_pay[$i]);
        $absent = floatval($absent_deduction[$i]);
        $bon = floatval($bonus[$i]);

        $gross = $hours * $rate;
        $total_pay = $gross + $ot + $bon - $late - $absent;

        // Insert into payslips table
        $stmt = $conn->prepare("INSERT INTO payslips (employee_id, start_date, end_date, total_hours, salary_rate, total_pay) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$emp_id, $start_date, $end_date, $hours, $rate, $total_pay]);
        $payslip_id = $conn->lastInsertId();

        // Insert details
        $details = [
            ['Late Deduction', $late, 'deductions'],
            ['Overtime Pay', $ot, 'earnings'],
            ['Absent Deduction', $absent, 'deductions'],
            ['Bonus', $bon, 'earnings']
        ];

        $detail_stmt = $conn->prepare("INSERT INTO payslip_details (payslip_id, label, amount, type) VALUES (?, ?, ?, ?)");
        foreach ($details as $detail) {
            [$label, $amount, $type] = $detail;
            if ($amount > 0) {
                $detail_stmt->execute([$payslip_id, $label, $amount, $type]);
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Payslips generated successfully.']);
}
?>
