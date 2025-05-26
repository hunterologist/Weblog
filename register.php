<?php
session_start();
$page_title = "Register";
include 'header.php';
include 'db.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // اصلاح نام متغیر
    $password = $_POST['password'];

    try {
        // عمداً آسیب‌پذیر به SQL Injection برای تمرین
        $query = "INSERT INTO `users` (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result === true) {
            header("Location: login.php?msg=You have registered successfully, please login");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        // عمداً اطلاعات خطا لو می‌ره برای تمرین
        $message = "Error: " . $e->getMessage();
    }
}
?>

<section class="login-page">
    <div class="login-box">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Register to Macan Weblog</h2>
        <?php if ($message): ?>
            <!-- عمداً آسیب‌پذیر به XSS برای تمرین -->
            <p class="text-red-500 text-center mb-4"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 font-semibold">Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter username" required>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter email" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter password" required>
            </div>
            <input type="submit" value="Register" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
            <p class="text-center text-gray-600 footer">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a></p>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>