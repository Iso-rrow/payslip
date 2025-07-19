<?php
include '../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$conn->query("INSERT IGNORE INTO payslip_defaults (id) VALUES (1)");

$stmt = $conn->prepare("
    UPDATE payslip_defaults SET
    sss = ?, pagibig = ?, philhealth = ?, withholding_tax = ?,
    late_deduction = ?, absent_deduction = ?, allowance = ?, overtime_pay = ?, bonus = ?
    WHERE id = 1
");

$stmt->bind_param(
    "ddddddddd",
    $data['sss'], $data['pagibig'], $data['philhealth'], $data['withholding_tax'],
    $data['late_deduction'], $data['absent_deduction'],
    $data['allowance'], $data['overtime_pay'], $data['bonus']
);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
