<?php
session_start();
$page_title = "My Posts";
include 'header.php';
include 'db.php';

if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true) {
    $user_id = $_SESSION['id'];

    // لود پست‌های کاربر
    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $sql = "SELECT p.*, c.categories_name FROM posts p JOIN categories c ON p.category_id = c.categories_id WHERE p.author_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<section class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">My Posts</h1>

    <?php if (isset($_GET['msg'])): ?>
        <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
        <p class="text-green-500 text-center mb-4"><?php echo $_GET['msg']; ?></p>
    <?php endif; ?>

    <?php if (empty($posts)): ?>
        <p class="text-gray-600 text-center">You haven't posted anything yet. <a href="write_post.php" class="text-blue-600 hover:underline">Write a post now!</a></p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                    <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
                    <p class="text-gray-600 mb-4"><?php echo $post['content']; ?></p>
                    <p class="text-sm text-gray-500 mb-2">Category: <?php echo htmlspecialchars($post['categories_name']); ?></p>
                    <p class="text-sm text-gray-500 mb-2">Published on: <?php echo htmlspecialchars($post['created_at'] ?? 'Unknown'); ?></p>
                    <!-- عمداً آسیب‌پذیر به IDOR برای تمرین -->
                    <div class="space-x-2 flex items-center">
                        <a href="view_post.php?post_id=<?php echo $post['id']; ?>" class="text-blue-600 hover:underline">View</a>
                        <a href="edit_post.php?post_id=<?php echo $post['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">Edit</a>
                        <a href="delete_post.php?post_id=<?php echo $post['id']; ?>" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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