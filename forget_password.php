<?php
include 'header.php';
include 'db.php';
include 'functions.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $random_string = md5(generateRandomString(10));
        $update_query = "UPDATE users SET `token` = '$random_string' WHERE username = '$username'";
        $update_result = mysqli_query($conn, $update_query);

        $message = "The reset link has been sent to your email address: " . htmlspecialchars($row['email']) . "<br>";
        $message .= "http://" . htmlspecialchars($_SERVER['SERVER_NAME']) . "/reset_password.php?token=" . $random_string;
    } else {
        $message = "<p style='color:red'>User not found.</p>";
    }
}
?>

<section class="max-w-md mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Forgot Password</h1>

    <?php if ($message): ?>
        <p class="text-center mb-4"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="forget_password.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" class="w-full p-2 border rounded" required>
            </div>
            <input type="submit" value="Reset" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>