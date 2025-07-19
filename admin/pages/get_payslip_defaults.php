<?php
include '../../database/connect.php';

$result = $conn->query("SELECT * FROM payslip_defaults WHERE id = 1");
echo json_encode($result->fetch_assoc());
?>
