<?php
include '../../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $documents = '';
    $imageFileName = null;

   // Handle image upload or keep existing image
if (!empty($_FILES['employee_image']['name'])) {
    $uploadImageDir = '../../uploads/employees/';
    if (!is_dir($uploadImageDir)) {
        mkdir($uploadImageDir, 0777, true);
    }

    $originalImageName = basename($_FILES['employee_image']['name']);
    $uniqueImageName = time() . '_' . $originalImageName;
    $targetImagePath = $uploadImageDir . $uniqueImageName;

    if (move_uploaded_file($_FILES['employee_image']['tmp_name'], $targetImagePath)) {
        $imageFileName = '/h_r_3/uploads/employees/' . $uniqueImageName;

        
        if (!empty($_POST['existing_image_name']) && $_POST['existing_image_name'] !== 'default.jpg') {
            $oldImagePath = '../../uploads/employees/' . basename($_POST['existing_image_name']);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
    }
} else {
    
    $imageFileName = $_POST['existing_image_name'] ?? 'default.jpg';
}


    // Handle documents
    if (!empty($_FILES['documents']['name'][0])) {
        $uploadDocDir = '../../uploads/documents/';
        if (!is_dir($uploadDocDir)) {
            mkdir($uploadDocDir, 0777, true);
        }

        $fileNames = [];

        foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
            if (!empty($_FILES['documents']['name'][$key])) {
                $originalDocName = basename($_FILES['documents']['name'][$key]);
                $uniqueDocName = time() . '_' . $originalDocName;
                $targetDocPath = $uploadDocDir . $uniqueDocName;

                if (move_uploaded_file($tmp_name, $targetDocPath)) {
                    $fileNames[] = '/h_r_3/uploads/documents/' . $uniqueDocName;
                }
            }
        }

        $documents = implode(',', $fileNames);
    }

    // Base query
    $query = "UPDATE employees SET 
        first_name = ?, 
        last_name = ?, 
        email = ?, 
        contact_number = ?, 
        department = ?, 
        position = ?, 
        hire_date = ?, 
        sss_number = ?, 
        philhealth_number = ?, 
        pagibig_number = ?, 
        tin_number = ?, 
        salary_rate = ?, 
        payment_method = ?, 
        address = ?, 
        emergency_name = ?, 
        emergency_phone = ?, 
        civil_status = ?, 
        sex = ?, 
        citizenship = ?, 
        height = ?, 
        weight = ?, 
        religion = ?";

    $types = "sssssssssssdsssssssiis"; // add more below if needed
    $params = [
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['contact_number'],
        $data['department'],
        $data['position'],
        $data['hire_date'],
        $data['sss_number'],
        $data['philhealth_number'],
        $data['pagibig_number'],
        $data['tin_number'],
        $data['salary_rate'],
        $data['payment_method'],
        $data['address'],
        $data['emergency_name'],
        $data['emergency_phone'],
        $data['civil_status'],
        $data['sex'],
        $data['citizenship'],
        $data['height'],
        $data['weight'],
        $data['religion']
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
    $params[] = $data['employee_id'];

    // Prepare statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    // Bind dynamically
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
