<?php
include 'header.php';
include 'db.php';
include 'functions.php';
?>

<div class="login-box">
    <h2>Reset Password</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $token = $_POST["token"];

    // بررسی توکن برای امنیت
    $sql = "SELECT * FROM users WHERE username = '$username' AND token = '$token'";
    $check = mysqli_query($conn, $sql);

    if ($check && mysqli_num_rows($check) == 1) {
        // تغییر رمز عبور
        $query = "UPDATE users SET password = '$password', token = NULL WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result === true) {
            header("Location: login.php?msg=The new password has been set successfully");
            exit;
        } else {
            echo "<p style='color:red;'>Failed to update password!</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid token or username!</p>";
    }
}

// نمایش فرم زمانی که GET token هست
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $token_result = true;
    }
}

if ($token_result === true) { ?> 


<form action="reset_password.php" method="POST">

    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="hidden" id="username" name="username" value="<?php echo $row['username']; ?>">
    <input type="submit" value="Reset the password"><br>
</form>

<?php 
} else if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo '<p style="color:red;">The provided token is not valid or has expired.</p>';
}
?>

<div class="footer">
    &copy; 2025 My Weblog. All rights reserved
</div>

<?php include 'footer.php'; ?>
