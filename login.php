<?php
session_start();
$page_title = "Login";
include 'header.php';
include 'db.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['is_logged'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        header("Location: user_panel.php");
        exit;
    } else {
        // عمداً آسیب‌پذیر به XSS برای تمرین
        $message = "Invalid username or password. Please try again. <br> If you cannot remember your password please <a href='forget_password.php?username=$username'>Click here</a>";
    }
}
?>

<section class="login-page">
    <div class="login-box">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Login to Macan Weblog</h2>
        <?php if ($message): ?>
            <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
            <p class="text-red-500 text-center mb-4"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 font-semibold">Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter your username" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter your password" required>
            </div>
            <input type="submit" value="Login" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
            <p class="text-center text-gray-600 footer">Need a registration? <a href="register.php" class="text-blue-600 hover:underline">Register here</a></p>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>