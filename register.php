<?php
include 'header.php';
include 'db.php';
?>

<div class="login-box">
    <h2>Registration</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $Email = $_POST['Email'] ?? '';

        // بررسی اینکه فیلدها خالی نباشن
        if (empty($username) || empty($password) || empty($Email)) {
            echo "<p style='color: red;'>لطفا همه فیلدها را پر کنید.</p>";
        } else {
            try {
                $query = "INSERT INTO users (username, password, Email) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sss", $username, $password, $Email);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    header("Location: login.php?msg=You have registered successfully");
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                echo "<p style='color: red;'>خطا: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }
    ?>

    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="Email" placeholder="Email" required><br>
        <input type="submit" value="Register"><br>
        <a href='login.php'>Already have an account?</a>
    </form>

    <div class="footer">
        &copy; 2025 My Weblog. All rights reserved
    </div>
</div>

<?php
include 'footer.php';
?>
