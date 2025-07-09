<?php
include '../../database/connect.php';
header('Content-Type: application/json');

// DataTables parameters
$draw = intval($_POST['draw'] ?? 1);
$start = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$searchValue = $_POST['search']['value'] ?? '';
$orderColumnIdx = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';

// Column mapping (should match JS order)
$columns = [
    'id',            // for checkbox
    'employee_id',
    'name',
    'email',
    'role',
    'created_at'
];

$orderColumn = $columns[$orderColumnIdx] ?? 'created_at';

// Prepare search query
$searchSQL = '';
$params = [];
$types = '';

if ($searchValue !== '') {
    $searchSQL = "WHERE employee_id LIKE ? OR name LIKE ? OR email LIKE ? OR role LIKE ? OR created_at LIKE ?";
    $searchTerm = '%' . $searchValue . '%';
    $params = array_fill(0, 5, $searchTerm);
    $types = str_repeat('s', 5);
}

// Count total records
$totalRecordsQuery = "SELECT COUNT(*) FROM users";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_row()[0];

// Count filtered records
if ($searchSQL) {
    $countFilteredQuery = "SELECT COUNT(*) FROM users $searchSQL";
    $stmt = $conn->prepare($countFilteredQuery);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->bind_result($filteredRecords);
    $stmt->fetch();
    $stmt->close();
} else {
    $filteredRecords = $totalRecords;
}

// Fetch filtered data
$dataSQL = "SELECT id, employee_id, name, email, role, created_at
            FROM users
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

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$stmt->close();
$conn->close();

// Return JSON for DataTables
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $users
]);
exit;
