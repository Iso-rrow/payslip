<?php
header('Content-Type: application/json');
include '../../database/connect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $employee_ids = $input['employee_ids'] ?? [];
    $start_date = $input['start_date'] ?? null;
    $end_date = $input['end_date'] ?? null;

    if (empty($employee_ids) || !$start_date || !$end_date) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
        exit;
    }

    $response = [];

    foreach ($employee_ids as $emp_id) {
        // Step 1: Check if a payslip already exists
        $stmt = $conn->prepare("SELECT * FROM payslips WHERE employee_id = ? AND start_date = ? AND end_date = ?");
        $stmt->bind_param("iss", $emp_id, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $payslip = $result->fetch_assoc();

        if ($payslip) {
            // Found existing payslip – use it
            $stmt = $conn->prepare("SELECT first_name, last_name FROM employees WHERE employee_id = ?");
            $stmt->bind_param("i", $emp_id);
            $stmt->execute();
            $emp_result = $stmt->get_result();
            $emp = $emp_result->fetch_assoc();

            $response[] = [
                'employee_id' => $emp_id,
                'name' => $emp['first_name'] . ' ' . $emp['last_name'],
                'total_hours' => $payslip['total_hours'],
                'salary_rate' => $payslip['salary_rate'],
                'basic_salary' => $payslip['total_pay'],

                // You can expand your payslips table to include these if needed
                'allowance' => $payslip['allowance'] ?? 0.00,
                'bonus' => $payslip['bonus'] ?? 0.00,
                'overtime_pay' => $payslip['overtime_pay'] ?? 0.00,

                'withholding_tax' => $payslip['withholding_tax'] ?? 0.00,
                'sss' => $payslip['sss'] ?? 0.00,
                'pagibig' => $payslip['pagibig'] ?? 0.00,
                'philhealth' => $payslip['philhealth'] ?? 0.00,
                'late_deduction' => $payslip['late_deduction'] ?? 0.00,
                'absent_deduction' => $payslip['absent_deduction'] ?? 0.00
            ];
        } else {
            // Step 2: Calculate fresh if no payslip found
            $stmt = $conn->prepare("SELECT employee_id, first_name, last_name, salary_rate FROM employees WHERE employee_id = ?");
            $stmt->bind_param("i", $emp_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $emp = $result->fetch_assoc();

            if (!$emp) continue;

            $stmt = $conn->prepare("SELECT date, MAX(TIMESTAMPDIFF(SECOND, time_in, time_out)) AS seconds_worked
                                    FROM attendance
                                    WHERE employee_id = ? AND date BETWEEN ? AND ?
                                      AND time_in IS NOT NULL AND time_out IS NOT NULL
                                    GROUP BY date");
            $stmt->bind_param("iss", $emp_id, $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();

            $total_seconds = 0;
            while ($row = $result->fetch_assoc()) {
                $total_seconds += (int)$row['seconds_worked'];
            }

            $total_hours = round($total_seconds / 3600, 2);
            $basic_salary = round($total_hours * $emp['salary_rate'], 2);

            $response[] = [
                'employee_id' => $emp['employee_id'],
                'name' => $emp['first_name'] . ' ' . $emp['last_name'],
                'total_hours' => $total_hours,
                'salary_rate' => $emp['salary_rate'],
                'basic_salary' => $basic_salary,

                // Default values
                'allowance' => 0.00,
                'bonus' => 0.00,
                'overtime_pay' => 0.00,

                'withholding_tax' => 0.00,
                'sss' => 0.00,
                'pagibig' => 0.00,
                'philhealth' => 0.00,
                'late_deduction' => 0.00,
                'absent_deduction' => 0.00
            ];
        }
    }

    echo json_encode(['status' => 'success', 'employees' => $response]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
