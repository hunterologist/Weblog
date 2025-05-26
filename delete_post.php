<?php
session_start();
$page_title = "Delete Post";
include 'header.php';
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
    header('Location: login.php');
    exit();
}

// Validate post_id
if (!isset($_GET['post_id'])) {
    $message = "No post ID provided.";
} else {
    $post_id = intval($_GET['post_id']);
    if ($post_id <= 0) {
        $message = "Invalid post ID.";
    } else {
        $sql = "SELECT author_id FROM posts WHERE post_id = $post_id";
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) === 0) {
            $message = "Post not found.";
        } else {
            $post = mysqli_fetch_assoc($result);
            // عمداً ناقص برای تمرین IDOR
            if ($_SESSION['id'] != $post['author_id']) {
                $message = "You are not authorized to delete this post.";
            } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Delete the post
                $sql = "DELETE FROM posts WHERE post_id = $post_id";
                if (mysqli_query($conn, $sql)) {
                    header("Location: my_posts.php?msg=Your post has been deleted successfully!");
                    exit();
                } else {
                    $message = "Error deleting the post: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<section class="max-w-md mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Delete Post</h1>

    <?php if (isset($message)): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
        <p class="text-center"><a href="my_posts.php" class="text-blue-600 hover:underline">Back to My Posts</a></p>
    <?php elseif (isset($post)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-600 mb-4">Are you sure you want to delete this post?</p>
            <form action="" method="POST">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Yes, Delete</button>
                <a href="my_posts.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 ml-2 transition duration-300">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>