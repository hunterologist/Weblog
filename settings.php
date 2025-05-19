<?php
include 'db.php';
session_start();

if (isset($_SESSION['is_logged']) === true) {

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $id = $_POST['id'];
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $bio = mysqli_real_escape_string($conn, $_POST['bio']);
      $password_change = false;
  
      if ($password === ""){
          $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio' where `id` = " . intval($id);
      }else{
        $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio', `password` = '$password' where `id` = " . intval($id);
        $password_change = true;
      }

      try {
          $result = mysqli_query($conn, $sql);
          if ($result === true){
              if ($password_change === true) header("Location: logout.php"); 
              else header("Location: settings.php");
          }
      } catch (mysqli_sql_exception $e) {
          $message = $e->getMessage();
          print($message);
      }
      exit;
  }

  try {
      $sql = "select * from `users` where id = " . $_SESSION['id'];
      $result = mysqli_query($conn, $sql);
      $user_information = mysqli_fetch_assoc($result);

      //print_r($user_informationow);

  } catch (mysqli_sql_exception $e) {
      $message = $e->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Macan Weblog</title>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color:rgb(141, 196, 241); color:rgb(0, 0, 0); }
    header { background-color: #4a90e2; color: white; padding: 1rem 2rem; text-align: center; }
    nav { background-color: #333; padding: 0.5rem; text-align: center; }
    nav ul { list-style: none; padding: 0; margin: 0; display: flex; justify-content: center; gap: 20px; }
    nav a { color: white; text-decoration: none; font-weight: bold; padding: 0.5rem 1rem; transition: background-color 0.3s; }
    nav a:hover { background-color: #444; border-radius: 4px; }
    .container { max-width: 900px; margin: 2rem auto; padding: 1rem; background-color: white; box-shadow: 0 0 10px rgba(0,0,0,0.05); border-radius: 8px; }
    .form-group { margin-bottom: 1rem; }
    label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
    input, textarea { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 5px; }
    button { padding: 0.7rem 1.5rem; background-color: #4a90e2; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
    button:hover { background-color: #357ac9; }
    footer { text-align: center; padding: 1rem; color: #777; font-size: 0.9rem; }
    section {color: black; padding: 0rem;text-align: center;  font-size: 1rem;}

  </style>
</head>
<body>

<header>
  <h1>Settings</h1>
  <p>Thoughts, stories, and ideas.</p>
</header>

<nav>
  <ul>
    <li><a href="#">Panel</a></li>
    <li><a href="#">Write</a></li>
    <li><a href="#">Posts</a></li>
    <li><a href="settings.php">Settings</a></li>
    <li>(<?php echo $_SESSION['username']?>)<a href="logout.php">Logout</a></li>
  </ul>
</nav>

<div class="container">
        <section>
            <h1>Settings</h1>
            <p>This is a simple and smooth HTML template for your website.</p>
        </section>
        <img src="<?='/get_image.php?imgsrc=statics/images/' . md5($_SESSION['id']) . '.png';?>" onerror="this.src='/statics/images/user.jpg'" width="200" height="200"><img><br><br>
        <input type="file" id="imageUpload" accept="image/*"><br>
        <progress id="uploadProgress" max="100" value="0"></progress><br>
        <div id="message"></div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="/statics/upload.js"></script>

        <br>

        <form action="" method="POST">
        <!-- User ID (usually hidden) -->
        <input type="hidden" name="id" value="<?=$user_information['id'];?>"> <!-- Replace with the actual user_id -->

        <!-- Username -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?=$user_information['username'];?>" disabled><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?=$user_information['email'];?>" disabled><br>

        <!-- First Name -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?=$user_information['first_name'];?>"><br>

        <!-- Last Name -->
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?=$user_information['last_name'];?>"><br>

        <!-- Bio -->
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"><?=$user_information['bio'];?></textarea><br>

        <!-- Password -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value=""><br>
        <input type="submit" value="Update">
    </form>
<?php } else { ?>
<p>Redirecting you to login page...</p>
<script>
    // Delay the redirection for 3 seconds (adjust as needed)
    setTimeout(function () {
        // Specify the URL you want to redirect to
        window.location.href = '/login.php';

        // Display a message (optional)
        document.body.innerHTML = '<p>You are now being redirected to the new page.</p>';
    }, 3000); // 3000 milliseconds (3 seconds)
</script>
<?php } ?>
<footer>
    <p>&copy; 2023 Voorivex Weblog System. All rights reserved.</p>
</footer>

</body>
</html>
