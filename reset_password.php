<?php
include 'header.php';
include 'db.php';
include 'functions.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $sql = "UPDATE users SET password = '$password' WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result === true) {
        $sql = "UPDATE users SET `token` = NULL WHERE username = '$username'";
        $token_null = mysqli_query($conn, $sql);
        header("Location: login.php?msg=The new password has been set successfully");
        exit;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$token_result = false;
if (array_key_exists('token', $_GET)) {
    $token = $_GET['token'];

    // عمداً آسیب‌پذیر به SQL Injection برای تمرین
    $sql = "SELECT * FROM users WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $token_result = true;
    } else {
        $message = "Invalid or expired token.";
    }
}
?>

<section class="max-w-md mx-auto py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Reset Password</h1>

    <?php if ($message): ?>
        <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if ($token_result): ?>
        <form action="reset_password.php" method="post" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <input type="hidden" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>">

            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">New Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded" required>
            </div>

            <input type="submit" value="Reset Password" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition duration-300">
        </form>
    <?php else: ?>
        <p class="text-gray-600 text-center">The provided token is not valid or expired. <a href="/login.php" class="text-blue-600 hover:underline">Go back</a></p>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>