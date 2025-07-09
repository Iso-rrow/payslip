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
    'employee_id',
    'auto_employee_id',
    'first_name',
    'last_name',
    'department',
    'position',
    'hire_date'
];
$orderColumn = $columns[$orderColumnIdx] ?? 'hire_date';

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
$dataSQL = "SELECT employee_id, auto_employee_id, first_name, last_name, department, position, hire_date, img_name
            FROM employees
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
            $row['img_name'] = '/h_r_3/uploads/employees/' . $row['img_name'];
        }
    } else {
        $row['img_name'] = '/h_r_3/uploads/employees/default.jpg';
    }

    $employees[] = $row;
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
