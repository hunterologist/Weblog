<?php
session_start();
$page_title = "Edit Post";
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
        // Fetch the post and ensure it exists
        $sql = "SELECT * FROM posts WHERE post_id = $post_id";
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) === 0) {
            $message = "Post not found.";
        } else {
            $post = mysqli_fetch_assoc($result);

            // Check if the current user is authorized to edit the post
            // عمداً ناقص برای تمرین IDOR
            if ($_SESSION['id'] != $post['author_id']) {
                $message = "You are not authorized to edit this post.";
            }
        }
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($message)) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $sql_update = "UPDATE posts SET title = '$title', content = '$content' WHERE post_id = $post_id";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: my_posts.php?msg=Your post has been updated successfully!");
        exit();
    } else {
        $message = "Error updating the post: " . mysqli_error($conn);
    }
}
?>

<section class="max-w-2xl mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Post</h1>

    <?php if (isset($message)): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
        <p class="text-center"><a href="my_posts.php" class="text-blue-600 hover:underline">Back to My Posts</a></p>
    <?php elseif (isset($post)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <form action="" method="POST">
                <div>
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div>
                    <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                    <textarea id="content" name="content" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition duration-300">Update Post</button>
            </form>
            <p class="text-center"><a href="my_posts.php" class="text-blue-600 hover:underline">Cancel</a></p>
        </div>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>