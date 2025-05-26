<?php
session_start();
$page_title = "View Image";
include 'header.php';

$message = '';
if (isset($_GET['imgsrc'])) {
    $file = $_GET['imgsrc'];
    // عمداً فیلتر ناقص برای تمرین Directory Traversal
    $file = str_replace('..', '', $file);
    $filepath = __DIR__ . '/' . $file;

    if (file_exists($filepath)) {
        header('Content-Type: ' . mime_content_type($filepath));
        readfile($filepath);
        exit;
    } else {
        $message = "Image not found: " . htmlspecialchars($file);
    }
} else {
    $message = "No image specified.";
}
?>

<section class="max-w-md mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">View Image</h1>
    <div class="bg-white p-6 rounded-lg shadow-md text-center">
        <?php if ($message): ?>
            <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
            <p class="text-red-500 mb-4"><?php echo $message; ?></p>
        <?php endif; ?>
        <p class="text-gray-600"><a href="settings.php" class="text-blue-600 hover:underline">Back to Settings</a></p>
    </div>
</section>

<?php include 'footer.php'; ?>