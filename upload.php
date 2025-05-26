<?php
session_start();
include 'db.php';

// فعال کردن نمایش خطاها برای دیباگ
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in to upload an image.']);
    exit();
}

$user_id = $_SESSION['id'];
$upload_dir = __DIR__ . '/statics/images/';

// Create directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Check directory permissions
if (!is_writable($upload_dir)) {
    echo json_encode(['status' => 'error', 'message' => 'Upload directory is not writable.']);
    exit();
}

// Check if file is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_name = md5($user_id) . '.png'; // Use user_id to create unique filename
    $file_path = $upload_dir . $file_name;

    // Validate file type (only allow images)
    $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
    $file_type = mime_content_type($file_tmp);
    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Only PNG, JPEG, and GIF files are allowed.']);
        exit();
    }

    // Move the uploaded file
    if (move_uploaded_file($file_tmp, $file_path)) {
        echo json_encode(['status' => 'success', 'message' => 'Image uploaded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image. Check directory permissions.']);
    }
} else {
    $error_message = $_FILES['image']['error'] ?? 'Unknown error';
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error occurred: ' . $error_message]);
}
?>