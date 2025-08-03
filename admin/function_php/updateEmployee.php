<?php
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $documents = '';
    $imageFileName = null;

    if (empty($data['employee_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing employee_id']);
        exit;
    }


    // Handle image upload
    if (!empty($_FILES['employee_image']['name'])) {
        $uploadImageDir = '../../uploads/employees/';
        if (!is_dir($uploadImageDir)) {
            mkdir($uploadImageDir, 0777, true);
        }

        $originalImageName = basename($_FILES['employee_image']['name']);
        $uniqueImageName = time() . '_' . $originalImageName;
        $targetImagePath = $uploadImageDir . $uniqueImageName;

        if (move_uploaded_file($_FILES['employee_image']['tmp_name'], $targetImagePath)) {
            $imageFileName = '/payslip/uploads/employees/' . $uniqueImageName;

            if (!empty($_POST['existing_image_name']) && $_POST['existing_image_name'] !== 'default.jpg') {
                $oldImagePath = '../../uploads/employees/' . basename($_POST['existing_image_name']);
                if (file_exists($oldImagePath)) unlink($oldImagePath);
            }
        }
    } else {
        $imageFileName = $_POST['existing_image_name'] ?? 'default.jpg';
    }

    // Handle document uploads
    if (!empty($_FILES['documents']['name'][0])) {
        $uploadDocDir = '../../uploads/documents/';
        if (!is_dir($uploadDocDir)) mkdir($uploadDocDir, 0777, true);

        $fileNames = [];
        foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
            if (!empty($_FILES['documents']['name'][$key])) {
                $originalDocName = basename($_FILES['documents']['name'][$key]);
                $uniqueDocName = time() . '_' . $originalDocName;
                $targetDocPath = $uploadDocDir . $uniqueDocName;

                if (move_uploaded_file($tmp_name, $targetDocPath)) {
                    $fileNames[] = '/payslip/uploads/documents/' . $uniqueDocName;
                }
            }
        }
        $documents = implode(',', $fileNames);
    }

    // Normalize time
    $scheduled_time_in = !empty($data['scheduled_time_in']) ? date('H:i:s', strtotime($data['scheduled_time_in'])) : null;
    $scheduled_time_out = !empty($data['scheduled_time_out']) ? date('H:i:s', strtotime($data['scheduled_time_out'])) : null;
    $hire_date = isset($data['hire_date']) ? date('Y-m-d', strtotime($data['hire_date'])) : null;



    // Prepare UPDATE query
    $query = "UPDATE employees SET 
        first_name = ?, last_name = ?, email = ?, contact_number = ?, 
        department = ?, position = ?, hire_date = ?, 
        scheduled_time_in = ?, scheduled_time_out = ?, 
        sss_number = ?, philhealth_number = ?, pagibig_number = ?, tin_number = ?, 
        salary_rate = ?, payment_method = ?, address = ?, 
        emergency_name = ?, emergency_phone = ?, civil_status = ?, sex = ?, 
        citizenship = ?, religion = ?, height = ?, weight = ?";

    $types = "sssssiisssssssdsssssssdd";
    $params = [
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['contact_number'],
        intval($data['department']),
        intval($data['position']),
        $hire_date,
        $scheduled_time_in,
        $scheduled_time_out,
        $data['sss_number'],
        $data['philhealth_number'],
        $data['pagibig_number'],
        $data['tin_number'],
        (float)$data['salary_rate'],
        $data['payment_method'],
        $data['address'],
        $data['emergency_name'],
        $data['emergency_phone'],
        $data['civil_status'],
        $data['sex'],
        $data['citizenship'],
        $data['religion'],
        (float)$data['height'],
        (float)$data['weight']
    ];

    if ($imageFileName !== null) {
        $query .= ", img_name = ?";
        $types .= "s";
        $params[] = $imageFileName;
    }

    if (!empty($documents)) {
        $query .= ", documents = ?";
        $types .= "s";
        $params[] = $documents;
    }

    $query .= " WHERE employee_id = ?";
    $types .= "i";
    $params[] = (int)$data['employee_id'];

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>