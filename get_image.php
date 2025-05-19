<?php
if (isset($_GET['imgsrc'])) {
    $file = $_GET['imgsrc'];
    $file = str_replace('..', '', $file); // امنیت
    $filepath = __DIR__ . '/' . $file;

    if (file_exists($filepath)) {
        header('Content-Type: ' . mime_content_type($filepath));
        readfile($filepath);
        exit;
    } else {
        http_response_code(404);
        echo 'Image not found.';
    }
} else {
    http_response_code(400);
    echo 'No image specified.';
}
