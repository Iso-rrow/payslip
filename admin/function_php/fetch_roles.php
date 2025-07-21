<?php
if (isset($_POST['department_id'])) {
    include "../../database/connect.php";

    $dept_id = intval($_POST['department_id']);
    $stmt = $conn->prepare("SELECT DISTINCT id, name FROM roles WHERE department_id = ?");
    $stmt->bind_param("i", $dept_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected>Select Role</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }

    $stmt->close();
}
