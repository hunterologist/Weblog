<?php
session_start();
$page_title = "Settings";
include 'header.php';
include 'db.php';

$message = '';
if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true) {
    $user_id = $_SESSION['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = intval($_POST['id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);
        $password_change = false;

        if ($password === "") {
            // عمداً آسیب‌پذیر به SQL Injection برای تمرین
            $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio' WHERE `id` = " . $id;
        } else {
            $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio', `password` = '$password' WHERE `id` = " . $id;
            $password_change = true;
        }

        try {
            $result = mysqli_query($conn, $sql);
            if ($result === true) {
                if ($password_change) {
                    header("Location: logout.php");
                } else {
                    header("Location: settings.php?msg=Settings updated successfully");
                }
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            // عمداً اطلاعات خطا لو می‌ره برای تمرین
            $message = "Error: " . $e->getMessage();
        }
    }

    try {
        $sql = "SELECT * FROM `users` WHERE id = " . $user_id;
        $result = mysqli_query($conn, $sql);
        $user_information = mysqli_fetch_assoc($result);
    } catch (mysqli_sql_exception $e) {
        $message = "Error: " . $e->getMessage();
    }
?>

<section class="max-w-3xl mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Settings</h1>

    <?php if (isset($_GET['msg'])): ?>
        <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
        <p class="text-green-500 text-center mb-4"><?php echo $_GET['msg']; ?></p>
    <?php endif; ?>

    <?php if ($message): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <!-- پروفایل کاربر -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Profile</h2>
            <img src="<?php echo '/get_image.php?imgsrc=statics/images/' . md5($user_id) . '.png'; ?>" onerror="this.src='/statics/images/user.jpg'" alt="Profile Image" class="w-40 h-40 rounded-full mx-auto mb-4">
            <input type="file" id="imageUpload" accept="image/*" class="block mx-auto mb-4">
            <progress id="uploadProgress" max="100" value="0" class="block mx-auto mb-4"></progress>
            <div id="message" class="text-center text-gray-600"></div>
        </div>

        <!-- فرم تنظیمات -->
        <form action="settings.php" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $user_id; ?>">

            <div class="form-group">
                <label for="username" class="block text-gray-700 font-semibold">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_information['username']); ?>" disabled class="w-full p-2 border rounded">
            </div>

            <div class="form-group">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_information['email']); ?>" disabled class="w-full p-2 border rounded">
            </div>

            <div class="form-group">
                <label for="first_name" class="block text-gray-700 font-semibold">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_information['first_name'] ?? ''); ?>" class="w-full p-2 border rounded">
            </div>

            <div class="form-group">
                <label for="last_name" class="block text-gray-700 font-semibold">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user_information['last_name'] ?? ''); ?>" class="w-full p-2 border rounded">
            </div>

            <div class="form-group">
                <label for="bio" class="block text-gray-700 font-semibold">Bio</label>
                <textarea id="bio" name="bio" class="w-full p-2 border rounded"><?php echo htmlspecialchars($user_information['bio'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="password" class="block text-gray-700 font-semibold">Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" value="" class="w-full p-2 border rounded">
            </div>

            <input type="submit" value="Update Settings" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/statics/upload.js"></script>

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