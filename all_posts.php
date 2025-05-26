<?php
session_start();
$page_title = "All Posts";
include 'header.php';
include 'db.php';

function author_id_to_name($conn, $id) {
    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = " . $id);
    $author = mysqli_fetch_assoc($result);
    return $author['username'] ?? 'Unknown';
}

function category_id_to_name($conn, $id) {
    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $result = mysqli_query($conn, "SELECT * FROM `categories` WHERE `categories_id` = " . $id);
    $category = mysqli_fetch_assoc($result);
    return $category['categories_name'] ?? 'Unknown';
}

$sql = "SELECT * FROM `posts`";
if (array_key_exists('author_id', $_GET)) {
    $author_id = intval($_GET['author_id']);
    $sql = "SELECT * FROM `posts` WHERE author_id = $author_id";
}

$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<section class="max-w-5xl mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">All Posts</h1>

    <?php if (empty($posts)): ?>
        <p class="text-gray-600 text-center">No posts found.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        <a href="view_post.php?post_id=<?php echo $post['post_id']; ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($post['title']); ?></a>
                    </h2>
                    <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
                    <p class="text-gray-600 mb-4"><?php echo $post['content']; ?></p>
                    <p class="text-sm text-gray-500 mb-2">Category: <?php echo htmlspecialchars(category_id_to_name($conn, $post['category_id'])); ?></p>
                    <p class="text-sm text-gray-500 mb-2">Published on: <?php echo htmlspecialchars($post['publication_date'] ?? 'Unknown'); ?></p>
                    <p class="text-sm text-gray-500">By: <a href="all_posts.php?author_id=<?php echo $post['author_id']; ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars(author_id_to_name($conn, $post['author_id'])); ?></a></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>