<?php
header('Content-Type: application/json');
include '../../database/connect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

function getWorkingDaysInMonth($year, $month, $holidays = []) {
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $workingDays = 0;
    for ($day = 1; $day <= $totalDays; $day++) {
        $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
        $dayOfWeek = date('N', strtotime($date));
        if ($dayOfWeek < 6 && !in_array($date, $holidays)) {
            $workingDays++;
        }
    }
    return $workingDays;
}

function getWorkingDaysBetween($startDate, $endDate, $holidays = []) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end->modify('+1 day'); // include end date

    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end);

    $workingDays = 0;
    foreach ($period as $date) {
        $dayOfWeek = $date->format('N');
        if ($dayOfWeek < 6 && !in_array($date->format('Y-m-d'), $holidays)) {
            $workingDays++;
        }
    }
    return $workingDays;
}

function computeSemiMonthlyWithholding($semiMonthlyPay) {
    if ($semiMonthlyPay <= 10417) {
        return 0.00;
    } elseif ($semiMonthlyPay <= 16666) {
        return ($semiMonthlyPay - 10417) * 0.15;
    } elseif ($semiMonthlyPay <= 33332) {
        return 937.50 + (($semiMonthlyPay - 16667) * 0.20);
    } elseif ($semiMonthlyPay <= 83332) {
        return 4270.70 + (($semiMonthlyPay - 33333) * 0.25);
    } elseif ($semiMonthlyPay <= 333332) {
        return 16770.70 + (($semiMonthlyPay - 83333) * 0.30);
    } else {
        return 91770.70 + (($semiMonthlyPay - 333333) * 0.35);
    }   
}

function calculateFixedMonthlyWithholdingTax($monthly_salary, $allowance) {
    $sss = $monthly_salary * 0.05;
    $pagibig = 100.00;
    $philhealth = ($monthly_salary <= 10000) ? 500 : (($monthly_salary <= 100000) ? $monthly_salary * 0.05 : 5000);
    $taxable_income = $monthly_salary - $allowance - ($sss + $pagibig + $philhealth);
    return round(computeSemiMonthlyWithholding($taxable_income / 2) * 2, 2); // monthly tax
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $employee_ids = $input['employee_ids'] ?? [];
    $start_date = $input['start_date'] ?? null;
    $end_date = $input['end_date'] ?? null;

    if (empty($employee_ids) || !$start_date || !$end_date) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
        exit;
    }

    $working_days = getWorkingDaysBetween($start_date, $end_date);
    $working_hours = $working_days * 8;
    $start_day = date('d', strtotime($start_date));
    $end_day = date('d', strtotime($end_date));

    $is_full_month = (date('Y-m-d', strtotime($start_date)) === date('Y-m-01', strtotime($start_date))) &&
                     (date('Y-m-d', strtotime($end_date)) === date('Y-m-t', strtotime($end_date)));
    $is_first_half = ($start_day <= 15 && $end_day <= 15);
    $is_second_half = ($start_day > 15);

    $response = [];

    foreach ($employee_ids as $emp_id) {
        $stmt = $conn->prepare("SELECT employee_id, first_name, last_name, salary_rate FROM employees WHERE employee_id = ?");
        $stmt->bind_param("i", $emp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $emp = $result->fetch_assoc();
        if (!$emp) continue;

        $monthly_salary = floatval($emp['salary_rate']);
        $hourly_rate = round($monthly_salary * 12 / 313 / 8, 2);
        $allowance = 1000;
        $bonus = 0;
        $overtime_pay = 0;

        // Worked hours
        $stmt = $conn->prepare("SELECT SUM(TIME_TO_SEC(IFNULL(total_time, '00:00:00'))) as total_seconds FROM attendance WHERE employee_id = ? AND date BETWEEN ? AND ?");
        $stmt->bind_param("iss", $emp_id, $start_date, $end_date);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $total_hours = round(($row['total_seconds'] ?? 0) / 3600, 2);

        $prorated_salary = $hourly_rate * $total_hours;

        // Late
        $stmt = $conn->prepare("SELECT SUM(late_minutes) as total_late FROM attendance WHERE employee_id = ? AND date BETWEEN ? AND ?");
        $stmt->bind_param("iss", $emp_id, $start_date, $end_date);
        $stmt->execute();
        $late_minutes = intval($stmt->get_result()->fetch_assoc()['total_late'] ?? 0);
        $late_deduction = round(($hourly_rate / 60) * $late_minutes, 2);

        // Absent
        $expected_hours = $working_hours;
        $absent_hours = max(0, $expected_hours - $total_hours);
        $absent_deduction = round($absent_hours * $hourly_rate, 2);

        // Government Contributions (only at end of month)
        $sss = $pagibig = $philhealth = 0;
        $is_end_of_month = date('d', strtotime($end_date)) == date('t', strtotime($end_date));
        if ($is_end_of_month) {
            $sss = round($monthly_salary * 0.05, 2);
            $pagibig = 100.00;
            $philhealth = ($monthly_salary <= 10000) ? 500.00 :
                          (($monthly_salary <= 100000) ? round($monthly_salary * 0.05, 2) : 5000.00);
        }

        // Fixed Monthly Tax (from full month logic)
        $fixed_monthly_tax = calculateFixedMonthlyWithholdingTax($monthly_salary, $allowance);

        // Allocate tax based on period
        if ($is_full_month) {
            $withholding_tax = $fixed_monthly_tax;
        } elseif ($is_first_half || $is_second_half) {
            $withholding_tax = round($fixed_monthly_tax / 2, 2);
        } else {
            $withholding_tax = round(($fixed_monthly_tax / 30) * $working_days, 2); // fallback for odd periods
        }

        $total_deductions = $sss + $pagibig + $philhealth + $late_deduction + $absent_deduction + $withholding_tax;
        $gross_earnings = $prorated_salary + $allowance + $bonus + $overtime_pay;
        $net_pay = $gross_earnings - $total_deductions;

        $response[] = [
            'employee_id' => $emp['employee_id'],
            'name' => $emp['first_name'] . ' ' . $emp['last_name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_hours' => $total_hours,
            'salary_rate' => $monthly_salary,
            'basic_salary' => $prorated_salary,
            'allowance' => $allowance,
            'bonus' => $bonus,
            'overtime_pay' => $overtime_pay,
            'withholding_tax' => $withholding_tax,
            'sss' => $sss,
            'pagibig' => $pagibig,
            'philhealth' => $philhealth,
            'late_deduction' => $late_deduction,
            'absent_deduction' => $absent_deduction,
            'gross_earnings' => $gross_earnings,
            'total_pay' => $gross_earnings,
            'net_pay' => round($net_pay, 2)
        ];
    }

    echo json_encode(['status' => 'success', 'employees' => $response]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
