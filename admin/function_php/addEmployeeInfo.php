<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
include "../../database/connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// 1. Validate & sanitize input
$first_name        = htmlspecialchars(trim($_POST['first_name'] ?? ''));
$last_name         = htmlspecialchars(trim($_POST['last_name'] ?? ''));
$email             = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$auto_employee_id = htmlspecialchars(trim($_POST['employee_id'] ?? ''));

// ... (rest of your sanitizing here, as before)

$contact_number    = htmlspecialchars(trim($_POST['contact_number'] ?? ''));
$department        = htmlspecialchars(trim($_POST['department'] ?? ''));
$position          = htmlspecialchars(trim($_POST['position'] ?? ''));
$hire_date         = htmlspecialchars(trim($_POST['hire_date'] ?? ''));
$sss_number        = htmlspecialchars(trim($_POST['sss_number'] ?? ''));
$philhealth_number = htmlspecialchars(trim($_POST['philhealth_number'] ?? ''));
$pagibig_number    = htmlspecialchars(trim($_POST['pagibig_number'] ?? ''));
$tin_number        = htmlspecialchars(trim($_POST['tin_number'] ?? ''));
$salary_rate       = trim($_POST['salary_rate'] ?? '');
$payment_method    = htmlspecialchars(trim($_POST['payment_method'] ?? ''));
$bank_name         = htmlspecialchars(trim($_POST['bank_name'] ?? ''));
$bank_account      = htmlspecialchars(trim($_POST['bank_account'] ?? ''));
$address           = htmlspecialchars(trim($_POST['address'] ?? ''));
$emergency_name    = htmlspecialchars(trim($_POST['emergency_name'] ?? ''));
$emergency_phone   = htmlspecialchars(trim($_POST['emergency_phone'] ?? ''));
$civil_status  = htmlspecialchars(trim($_POST['civil_status'] ?? ''));
$sex           = htmlspecialchars(trim($_POST['sex'] ?? ''));
$citizenship   = htmlspecialchars(trim($_POST['citizenship'] ?? ''));
$height        = isset($_POST['height']) ? floatval($_POST['height']) : null;
$weight        = isset($_POST['weight']) ? floatval($_POST['weight']) : null;
$religion      = htmlspecialchars(trim($_POST['religion'] ?? ''));
$documents     = ''; 

$errors = [];

// 2. Required field validation
if (
    !$first_name || !$last_name || !$email || !$contact_number || !$department ||
    !$position || !$hire_date || !$sss_number || !$philhealth_number ||
    !$pagibig_number || !$tin_number || $salary_rate === '' || !$payment_method
) {
    $errors[] = "Please fill in all required fields.";
}

// 3. Field length checks (keep your existing checks here)

// 4. Email and salary validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid Email format';
}
if (!is_numeric($salary_rate) || $salary_rate < 0) {
    $errors[] = 'Invalid salary rate';
} else {
    $salary_rate = round(floatval($salary_rate), 2);
}

// 5. If there are errors, return early
if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// **RATE LIMITING: Block if more than 3 emails sent to same address in past 1 hour**
$limitStmt = $conn->prepare("SELECT COUNT(*) FROM email_logs WHERE email = ? AND sent_at >= (NOW() - INTERVAL 1 HOUR)");
$limitStmt->bind_param('s', $email);
$limitStmt->execute();
$limitStmt->bind_result($sent_count);
$limitStmt->fetch();
$limitStmt->close();
if ($sent_count >= 3) {
    echo json_encode([
        'success' => false,
        'errors' => ['You have reached the registration/email limit for this address. Try again later.']
    ]);
    exit;
}

// 6. Email uniqueness check (users table)
$stmt_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt_check->bind_param('s', $email);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();
if ($count > 0) {
    echo json_encode(['success' => false, 'errors' => ["Email is already used for a user account."]]);
    exit;
}


// Handle profile image upload
$img_name = '';

if (!empty($_FILES['img_name']['name'])) {
    $uploadDir = '../../uploads/employees/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalFileName = basename($_FILES['img_name']['name']);
    $uniqueFileName = time() . '_' . $originalFileName;
    $targetFile = $uploadDir . $uniqueFileName;

    if (move_uploaded_file($_FILES['img_name']['tmp_name'], $targetFile)) {
        $img_name = str_replace('../../', '/payslip/', $targetFile);
    }
}



// Handle document uploads
$documents = ''; 

if (!empty($_FILES['documents']['name'][0])) {
    $uploadDir = '../../uploads/documents/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileNames = [];

    foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES['documents']['name'][$key]);
        $targetFile = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($tmp_name, $targetFile)) {
            $fileNames[] = str_replace('../../', '/payslip/', $targetFile);
            
        }
    }

    $documents = implode(',', $fileNames);
}

function uploadSingleFile($fileField, $uploadDir = '../../uploads/documents/') {
    if (!empty($_FILES[$fileField]['name'])) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $originalFileName = basename($_FILES[$fileField]['name']);
        $uniqueFileName = time() . '_' . $originalFileName;
        $targetFile = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $targetFile)) {
            return str_replace('../../', '/payslip/', $targetFile);
        }
    }
    return null;
}

// Upload new documents
$sss_file       = uploadSingleFile('sss_file');
$philhealth_file= uploadSingleFile('philhealth_file');
$pagibig_file   = uploadSingleFile('pagibig_file');
$drugtest_file  = uploadSingleFile('drugtest_file');
$nbi_file       = uploadSingleFile('nbi_file');
$medical_file   = uploadSingleFile('medical_file');



$conn->begin_transaction();

try {
    // Insert into employees
    $stmt1 = $conn->prepare("
    INSERT INTO employees (
        auto_employee_id, img_name, first_name, last_name, email, contact_number, department, position, hire_date,
        sss_number, philhealth_number, pagibig_number, tin_number, salary_rate,
        payment_method, bank_name, bank_account, address, emergency_name, emergency_phone,
        civil_status, sex, citizenship, height, weight, religion, documents, sss_file, philhealth_file, pagibig_file, drugtest_file, nbi_file, medical_file

    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,?)
");


   $stmt1->bind_param(
    "ssssssssssssssdssssssssddssssssss",
    $auto_employee_id,
    $img_name,
    $first_name,
    $last_name,
    $email,
    $contact_number,
    $department,
    $position,
    $hire_date,
    $sss_number,
    $philhealth_number,
    $pagibig_number,
    $tin_number,
    $salary_rate,    
    $payment_method,
    $bank_name,
    $bank_account,
    $address,
    $emergency_name,
    $emergency_phone,
    $civil_status,
    $sex,
    $citizenship,
    $height,         
    $weight,          
    $religion,
    $documents,
    $sss_file,
    $philhealth_file,
    $pagibig_file,
    $drugtest_file,
    $nbi_file,
    $medical_file
);




    if (!$stmt1->execute()) throw new Exception('Employee insert failed: ' . $stmt1->error);
    $employee_id = $conn->insert_id;
    $stmt1->close();

    // Create OTP and insert user account
    $otp = bin2hex(random_bytes(4));
    $hashed_password = password_hash($otp, PASSWORD_DEFAULT);
    $must_change_password = 1;
    $role = 'employee';

    // After inserting into employees and getting $employee_id
    $full_name = $first_name . ' ' . $last_name; // Concatenate names

    $stmt2 = $conn->prepare("
    INSERT INTO users (employee_id, name, email, password, must_change_password, role)
    VALUES (?, ?, ?, ?, ?, ?)
");
    $stmt2->bind_param('isssis', $employee_id, $full_name, $email, $hashed_password, $must_change_password, $role);
    if (!$stmt2->execute()) {
        throw new Exception('User insert failed: ' . $stmt2->error);
    }
    $stmt2->close();

    $conn->commit();

    // ====== PHPMailer SEND EMAIL SECTION =======
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $first_name . ' ' . $last_name);
        $mail->isHTML(true);
        $mail->Subject = 'Your Temporary Account Password';
        $mail->Body    = "Hi {$first_name},<br><br>Your one-time password is: <b>{$otp}</b><br><br>
        Please use this to log in .<br><br>
        <small>This is an automated message. Please do not reply.</small>";

        $mail->send();

        // **Log the sent email**
        $logStmt = $conn->prepare("INSERT INTO email_logs (email) VALUES (?)");
        $logStmt->bind_param('s', $email);
        $logStmt->execute();
        $logStmt->close();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Even if email fails, log attempt for rate limiting
        $logStmt = $conn->prepare("INSERT INTO email_logs (email) VALUES (?)");
        $logStmt->bind_param('s', $email);
        $logStmt->execute();
        $logStmt->close();

        echo json_encode([
            'success' => true,
            
            'mail_error' => $mail->ErrorInfo
        ]);
    }
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();




exit;