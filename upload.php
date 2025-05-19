<?php
session_start();
$uploadDirectory = "./statics/images/"; // مسیر ذخیره تصاویر آپلود شده

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $file = $_FILES["image"];

    // بررسی خطا در آپلود
    if ($file["error"] === UPLOAD_ERR_OK) {
        // گرفتن پسوند فایل اصلی
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        // ساخت نام یکتا برای فایل با پسوند اصلی
        $filename = uniqid() . "." . $ext;
        $destination = $uploadDirectory . $filename;

        // انتقال فایل آپلود شده به مسیر مقصد
        if (move_uploaded_file($file["tmp_name"], $destination)) {
            echo "Upload successful! File saved as: " . $filename;
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    } else {
        echo "Error during upload: " . $file["error"];
    }
} else {
    echo "Invalid request.";
}
?>
