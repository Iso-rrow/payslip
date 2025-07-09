<?php
header('Content-Type: application/json');
include "../../database/connect.php";

if (isset($_GET['employee_id'])) {
    $id = intval($_GET['employee_id']);

    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
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
