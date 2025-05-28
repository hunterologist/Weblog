<?php
session_start();
$page_title = "User Panel";
include 'header.php';
include 'db.php';

if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true) {
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // لود تعداد پست‌های کاربر
    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $sql = "SELECT COUNT(*) as post_count FROM posts WHERE author_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $post_count = $row['post_count'];

    // لود اطلاعات کاربر (مثلاً ایمیل یا تاریخ ثبت‌نام)
    $sql = "SELECT email, created_at FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
?>

<section class="max-w-4xl mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Welcome to Your Panel, <?php echo htmlspecialchars($username); ?>!</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <!-- اطلاعات کاربر -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Profile</h2>
            <p class="text-gray-600">Username: <?php echo htmlspecialchars($username); ?></p>
            <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
            <p class="text-gray-600">Email: <?php echo $user['email']; ?></p>
            <p class="text-gray-600">Joined: <?php echo htmlspecialchars($user['created_at'] ?? 'Unknown'); ?></p>
        </div>

        <!-- آمار -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Stats</h2>
            <p class="text-gray-600">Total Posts: <?php echo htmlspecialchars($post_count); ?></p>
        </div>

        <!-- لینک‌های سریع -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="write_post.php" class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700 transition duration-300">Write a New Post</a>
            <a href="my_posts.php" class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700 transition duration-300">View Your Posts</a>
            <a href="settings.php" class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700 transition duration-300">Settings</a>
            <a href="admin/backups/backup.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Go to Backup Page</a>
        </div>
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