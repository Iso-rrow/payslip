<?php
include '../../database/connect.php';
header('Content-Type: application/json');

$draw = intval($_POST['draw'] ?? 1);
$start = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$searchValue = $_POST['search']['value'] ?? '';
$orderColumnIdx = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';

$columns = [
    'e.employee_id',
    'e.auto_employee_id',
    'e.first_name',
    'e.last_name',
    'd.name',
    'r.name',
    'e.hire_date'
];

$orderColumn = $columns[$orderColumnIdx] ?? 'e.hire_date';


$searchSQL = '';
$params = [];
$types = '';

if ($searchValue !== '') {
    $searchSQL = "WHERE auto_employee_id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR department LIKE ? OR position LIKE ? OR hire_date LIKE ?";
    $searchTerm = '%' . $searchValue . '%';
    $params = array_fill(0, 6, $searchTerm);
    $types = str_repeat('s', 6);
}

// Total records
$totalRecordsQuery = "SELECT COUNT(*) FROM employees";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_row()[0];

// Filtered records
if ($searchSQL) {
    $countFilteredQuery = "SELECT COUNT(*) FROM employees $searchSQL";
    $stmt = $conn->prepare($countFilteredQuery);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->bind_result($filteredRecords);
    $stmt->fetch();
    $stmt->close();
} else {
    $filteredRecords = $totalRecords;
}

// Main data query (include img_name)
$dataSQL = "
    SELECT 
        e.employee_id, 
        e.auto_employee_id, 
        e.first_name, 
        e.last_name, 
        d.name AS department, 
        d.id AS department_id,
        r.name AS position, 
        r.id AS role_id,
        e.hire_date, 
        e.img_name,
        e.scheduled_time_in,
        e.scheduled_time_out
    FROM employees e
    LEFT JOIN departments d ON e.department = d.id
    LEFT JOIN roles r ON e.position = r.id
    $searchSQL
    ORDER BY $orderColumn $orderDir
    LIMIT ?, ?";



if ($searchSQL) {
    $params[] = $start;
    $params[] = $length;
    $types .= 'ii';
    $stmt = $conn->prepare($dataSQL);
    $stmt->bind_param($types, ...$params);
} else {
    $stmt = $conn->prepare($dataSQL);
    $stmt->bind_param('ii', $start, $length);
}

$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while ($row = $result->fetch_assoc()) {
    // Ensure valid image path
    if (!empty($row['img_name'])) {
        if (!str_contains($row['img_name'], '/uploads/employees/')) {
            $row['img_name'] = '/payslip/uploads/employees/' . $row['img_name'];
        }
    } else {
        $row['img_name'] = '/payslip/uploads/employees/default.jpg';
    }
    
     $employees[] = [
        'employee_id' => $row['employee_id'],
        'auto_employee_id' => $row['auto_employee_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'department' => $row['department'],
        'department_id' => $row['department_id'],
        'position' => $row['position'],
        'role_id' => $row['role_id'],
        'hire_date' => $row['hire_date'],
        'img_name' => $row['img_name'],
        'scheduled_time_in' => $row['scheduled_time_in'],
        'scheduled_time_out' => $row['scheduled_time_out']
    ];

}

$stmt->close();
$conn->close();

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $employees
]);
exit;
?>
