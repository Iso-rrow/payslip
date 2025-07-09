<?php
require '../../database/connect.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing employee ID']);
    exit;
}

$employee_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    
    if (!empty($row['img_name'])) {
        
        if (!str_contains($row['img_name'], '/uploads/employees/')) {
            $row['img_name'] = '/h_r_3/uploads/employees/' . $row['img_name'];
        }
    } else {
        $row['img_name'] = '/h_r_3/uploads/employees/default.jpg';
    }

    echo json_encode([
        'success' => true,
        'employee' => $row
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Employee not found'
    ]);
}

$stmt->close();
$conn->close();
?>
