<?php
$test_dir = __DIR__ . '/statics/images/';
if (!file_exists($test_dir)) {
    mkdir($test_dir, 0775, true);
}
$test_file = $test_dir . 'test.txt';
if (is_writable($test_dir)) {
    file_put_contents($test_file, 'Test write successful!');
    echo "Directory is writable. Test file created.";
    unlink($test_file); // پاک کردن فایل تست
} else {
    echo "Directory is not writable. Check permissions.";
}
?>
