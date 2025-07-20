<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../database/connect.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing employee ID']);
    exit;
}

$employee_id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT 
        e.*, 
        d.id AS department_id,
        r.department_id AS role_id 
    FROM employees e
    LEFT JOIN departments d ON e.department = d.name
    LEFT JOIN roles r ON e.position = r.name
    WHERE e.employee_id = ?
");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}


if ($row = $result->fetch_assoc()) {
    if (!empty($row['img_name'])) {
        if (!str_contains($row['img_name'], '/uploads/employees/')) {
            $row['img_name'] = '/payslip/uploads/employees/' . $row['img_name'];
        }
    } else {
        $row['img_name'] = '/payslip/uploads/employees/default.jpg';
    }

    echo json_encode(['success' => true, 'employee' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Employee not found']);
}

$stmt->close();
$conn->close();
?>
