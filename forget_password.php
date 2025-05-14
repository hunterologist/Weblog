<?php
include 'header.php';
include 'db.php';
include 'functions.php';
?>

<div class="login-box">
    <h2>Forget Password</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $random_string = md5(generateRandomString(10));
        $query = "UPDATE users SET `token` = '$random_string' WHERE username = '$username'";
        $update_result = mysqli_query ($conn, $sql);
           
        $message = "The reset link has been sent to your email address: " . $row['email'] . "<br>";    
        $message .= "http://" . $_SERVER['SERVER_NAME'] . "/reset_password.php?token=$random_string";
 
    } 
}
?>

<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php if(array_key_exists('username', $_GET)) echo $_GET['username']; ?>"><br><br>
    <input type="submit" value="Reset"><br>
</form>

<?php 
    if (isset($message)) {
        echo "<p style='color: green;'>$message</p>";
    }
?>

<div class="footer">
    &copy; 2025 My Weblog. All rights reserved
</div>

<?php include 'footer.php'; ?>
