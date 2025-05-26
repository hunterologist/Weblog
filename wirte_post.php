<?php
session_start();
$page_title = "Write a New Post";
include 'header.php';
include 'db.php';

if (isset($_SESSION['is_logged']) === true) {
    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['id'];
        $category_id = $_POST['category'];

        // عمداً آسیب‌پذیر به SQL Injection برای تمرین
        try {
            $sql = "INSERT INTO `posts` (title, content, author_id, category_id) VALUES ('$title', '$content', '$author_id', '$category_id')";
            $result = mysqli_query($conn, $sql);

            if ($result === true) {
                header("Location: my_posts.php?msg=Your post has been published successfully!");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    }

    // لود دسته‌بندی‌ها
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<section class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Write a New Post</h1>
    
    <?php if ($message): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-6">
        <!-- Title -->
        <div>
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" id="title" name="title" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter post title" required>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
            <textarea id="content" name="content" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" rows="8" placeholder="Hi, in this post I want to talk about..." required></textarea>
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select id="category" name="category" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                <?php foreach ($rows as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['categories_id']); ?>"><?php echo htmlspecialchars($row['categories_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition duration-300">Publish Post</button>
    </form>
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