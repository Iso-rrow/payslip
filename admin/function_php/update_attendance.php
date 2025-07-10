<?php
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $today = date('Y-m-d');

    $datetime_in = $today . ' ' . $time_in . ':00';
    $datetime_out = $today . ' ' . $time_out . ':00';


    $stmt = $conn->prepare("UPDATE time_logs SET time_in = ?, time_out = ? WHERE id = ?");
    $stmt->bind_param("ssi", $datetime_in, $datetime_out, $id);


    if ($stmt->execute()) {
        echo "Updated successfully.";
    } else {
        echo "Update failed.";
    }
}
