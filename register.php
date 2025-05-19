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
        $query = "INSERT INTO `users` (username, email, password) value ('$username', '$email', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result === true){
            // Redirect to a welcome page or dashboard
            header("Location: login.php?msg=You have registered successfully, please login");
        } 

        } catch (mysqli_sql_exception $e) { 
            var_dump($e->getMessage());
        }
    }
    ?>

<form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Register"><br>
    <a href='login.php'>You've already an account?</a>
</form>

<?php
  if (isset($message)) {
      echo "<p style='color: red;'>$message</p>";
  }
include 'footer.php';
?>
