<?php
session_start();
$page_title = "Upload Image";
include 'header.php';

$message = '';
$uploadDirectory = "./statics/images/";

if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
        $file = $_FILES["image"];

        // بررسی خطا در آپلود
        if ($file["error"] === UPLOAD_ERR_OK) {
            // گرفتن پسوند فایل اصلی
            $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
            // ساخت نام یکتا برای فایل با پسوند اصلی
            $filename = md5($_SESSION['id']) . "." . $ext; // نام فایل با ID کاربر
            $destination = $uploadDirectory . $filename;

            // انتقال فایل آپلود شده به مسیر مقصد
            if (move_uploaded_file($file["tmp_name"], $destination)) {
                $message = "Upload successful! File saved as: " . htmlspecialchars($filename);
            } else {
                // عمداً اطلاعات خطا لو می‌ره برای تمرین
                $message = "Error: Failed to move the uploaded file to $destination.";
            }
        } else {
            $message = "Error during upload: " . $file["error"];
        }
    }
?>

<section class="max-w-md mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Upload Profile Image</h1>

    <?php if ($message): ?>
        <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
        <p class="text-red-500 text-center mb-4"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="image" class="block text-gray-700 font-semibold">Choose an Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded">
            </div>
            <input type="submit" value="Upload Image" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
        </form>
        <p class="text-center text-gray-600 mt-4"><a href="settings.php" class="text-blue-600 hover:underline">Back to Settings</a></p>
    </div>
</section>

<?php } else { ?>
<section class="max-w-md mx-auto text-center py-12">
    <p class="text-lg text-gray-600">Redirecting you to login page...</p>
    <script>
        setTimeout(() => {
            window.location.href = '/login.php';
        }, 3000);
    </script>
</section>
<?php } ?>

<?php include 'footer.php'; ?>