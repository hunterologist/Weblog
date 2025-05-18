<?php
include 'header.php';
include 'db.php';
?>

<div class="login-box">
    <h2>Registration</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $Email = $_POST['Email'];

        try{
        $query = "INSERT INTO `users` (username, password, Email) value ('$username', '$password', '$Email')";
        $result = mysqli_query($conn, $query);

        if ($result === true){
            header("Location: login.php?msg=You have registered successfully"); 
        } 

        } catch (mysqli_sql_exception $e) { 
            var_dump($e->getMessage());
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
  if (isset($message)) {
      echo "<p style='color: red;'>$message</p>";
  }
include 'footer.php';
?>
