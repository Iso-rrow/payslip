<?php
include __DIR__ . '/../../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['payslips'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

foreach ($data['payslips'] as $p) {
    $stmt = $conn->prepare("
        INSERT INTO payslips (employee_id, start_date, end_date, total_hours, salary_rate, total_pay)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            total_hours = VALUES(total_hours),
            salary_rate = VALUES(salary_rate),
            total_pay = VALUES(total_pay)
    ");
    $stmt->bind_param(
        "issidd",
        $p['employee_id'],
        $p['start_date'],
        $p['end_date'],
        $p['total_hours'],
        $p['salary_rate'],
        $p['total_pay']
    );
    $stmt->execute();
}
echo json_encode(['status' => 'success']);
