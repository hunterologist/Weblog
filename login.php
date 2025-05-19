<div class="login-box">
    <?php
    session_start();
    include 'header.php';
    echo '<h2>Login</h2>';
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['is_logged'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            header("Location: user_panel.php");
        } else {
            // Authentication failed
            $message = "Invalid username or password.Please try again. <br> If you cannot remember your password please <a href='forget_password.php?username=$username'>Click here</a>";
            $username = $_POST['username'];
          }
    }
    ?>
    <form action="login.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" placeholder="username" required><br>
      
      <label for="password">Password:</label>
      <input type="password" name="password" placeholder="Password" required><br>
      
      <input type="submit" value="Login"><br>
      <a href= 'register.php'>Need a registration?</a><br>
    </form>
    <?php 
    if (array_key_exists('msg', $_GET)){
        $message = $_GET ['msg'];
    }
    if (isset($message)) {
        echo "<p style='color: red;'>$message</p>";
    }
    include 'footer.php';
    ?>