<?php
header('Content-Type: application/json');
include "../../database/connect.php";

if (isset($_GET['employee_id'])) {
    $id = intval($_GET['employee_id']);

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

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($employee = $result->fetch_assoc()) {
        echo json_encode($employee);
    } else {
        echo json_encode(['error' => 'Employee not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Employee ID not provided']);
}
?>
