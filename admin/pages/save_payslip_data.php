<?php
include __DIR__ . '/../../../database/connect.php';

// Function to calculate working days (Mon–Fri)
function getWorkingDaysInMonth($year, $month, $holidays = []) {
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $workingDays = 0;
    for ($day = 1; $day <= $totalDays; $day++) {
        $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
        $dayOfWeek = date('N', strtotime($date)); // 1 = Mon, 7 = Sun
        if ($dayOfWeek < 6 && !in_array($date, $holidays)) {
            $workingDays++;
        }
    }
    return $workingDays;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['payslips'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

foreach ($data['payslips'] as $p) {
    $employee_id = $p['employee_id'];
    $start_date = $p['start_date'];
    $end_date = $p['end_date'];
    $total_hours = $p['total_hours'];
    $semi_month_salary = $p['salary_rate']; // This is half of the monthly rate

    $year = (int)date('Y', strtotime($start_date));
    $month = (int)date('m', strtotime($start_date));
    $holidays = [];

    $working_days = getWorkingDaysInMonth($year, $month, $holidays);
    $working_hours = $working_days * 8;
    $monthly_salary = $semi_month_salary * 2;
    $hourly_rate = $working_hours > 0 ? round($monthly_salary / $working_hours, 2) : 0;

    // Inputs with default fallback
    $bonus = $p['bonus'] ?? 0;
    $allowance = $p['allowance'] ?? 0;
    $overtime_pay = $p['overtime_pay'] ?? 0;
    $late_deduction = $p['late_deduction'] ?? 0;
    $absent_deduction = $p['absent_deduction'] ?? 0;

    $cutoff_day = (int)date('d', strtotime($start_date));

    // Only calculate deductions during second cutoff (e.g. 16–end)
    if ($cutoff_day >= 16) {
        $sss = round($monthly_salary * 0.05, 2);
        $pagibig = 100.00;
        if ($monthly_salary <= 10000) {
            $philhealth = 500.00;
        } elseif ($monthly_salary <= 100000) {
            $philhealth = round($monthly_salary * 0.05, 2);
        } else {
            $philhealth = 5000.00;
        }

        // Example withholding tax logic (adjust as needed)
        $withholding_tax = round(($monthly_salary - ($sss + $pagibig + $philhealth)) * 0.05, 2);
    } else {
        $sss = $pagibig = $philhealth = $withholding_tax = 0;
    }

    $total_deductions = $sss + $pagibig + $philhealth + $late_deduction + $absent_deduction + $withholding_tax;
    $net_pay = $semi_month_salary - $total_deductions + $bonus + $allowance + $overtime_pay;

    $stmt = $conn->prepare("INSERT INTO payslips 
        (employee_id, start_date, end_date, total_hours, salary_rate, total_pay, bonus, allowance, overtime_pay, withholding_tax, sss, pagibig, philhealth, late_deduction, absent_deduction)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            total_hours = VALUES(total_hours),
            salary_rate = VALUES(salary_rate),
            total_pay = VALUES(total_pay),
            bonus = VALUES(bonus),
            allowance = VALUES(allowance),
            overtime_pay = VALUES(overtime_pay),
            withholding_tax = VALUES(withholding_tax),
            sss = VALUES(sss),
            pagibig = VALUES(pagibig),
            philhealth = VALUES(philhealth),
            late_deduction = VALUES(late_deduction),
            absent_deduction = VALUES(absent_deduction)");

    $stmt->bind_param("issiddddddddddd",
        $employee_id,
        $start_date,
        $end_date,
        $total_hours,
        $semi_month_salary,
        $net_pay,
        $bonus,
        $allowance,
        $overtime_pay,
        $withholding_tax,
        $sss,
        $pagibig,
        $philhealth,
        $late_deduction,
        $absent_deduction
    );

    $stmt->execute();
}

echo json_encode(['status' => 'success']);
?>
