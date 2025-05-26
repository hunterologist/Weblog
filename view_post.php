<?php
session_start();
$page_title = "View Post";
include 'header.php';
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
    header('Location: login.php');
    exit();
}

// Get post ID from URL
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ($post_id <= 0) {
    $message = "Invalid post ID.";
} else {
    // Fetch post from database with category
    // عمداً ناقص برای تمرین IDOR
    $sql = "SELECT p.*, c.categories_name FROM posts p JOIN categories c ON p.category_id = c.categories_id WHERE p.post_id = $post_id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    if (!$post) {
        $message = "Post not found.";
    }
}
?>

<section class="max-w-3xl mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">View Post</h1>

    <?php if (isset($message)): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
        <p class="text-center"><a href="my_posts.php" class="text-blue-600 hover:underline">Back to My Posts</a></p>
    <?php elseif (isset($_GET['redirect']) && !empty($_GET['redirect'])): ?>
        <!-- عمداً آسیب‌پذیر به Open Redirect برای تمرین -->
        <script>
            setTimeout(() => {
                window.location.href = "<?php echo $_GET['redirect']; ?>";
            }, 3000);
        </script>
        <p class="text-gray-600 text-center mb-4">Redirecting you back...</p>
    <?php else: ?>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($post['title']); ?></h2>
            <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
            <p class="text-gray-600 mb-4"><?php echo $post['content']; ?></p>
            <p class="text-sm text-gray-500 mb-2">Category: <?php echo htmlspecialchars($post['categories_name']); ?></p>
            <p class="text-sm text-gray-500 mb-4">Published on: <?php echo htmlspecialchars($post['publication_date'] ?? 'Unknown'); ?></p>
            <p class="text-center"><a href="my_posts.php" class="text-blue-600 hover:underline">Back to My Posts</a></p>
        </div>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>