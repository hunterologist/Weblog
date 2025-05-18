<?php
include 'db.php';
session_start();

if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
  echo "<p>Redirecting you to login page...</p>";
  echo "<script>
    setTimeout(function () {
      window.location.href = '/login.php';
      document.body.innerHTML = '<p>Redirect failed</p>';
    }, 3000);
  </script>";
  exit;
}

try {
  $query = "SELECT * FROM `users` WHERE id = " . intval($_SESSION['id']);
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
} catch (mysqli_sql_exception $e) {
  die("Database Error: " . $e->getMessage());
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
  $bio        = mysqli_real_escape_string($conn, $_POST['bio']);
  $password   = mysqli_real_escape_string($conn, $_POST['password']);
  $update_query = "";

  if ($password === "") {
    $update_query = "UPDATE users SET 
      first_name = '$first_name', 
      last_name = '$last_name', 
      bio = '$bio' 
      WHERE id = " . intval($_SESSION['id']);
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $update_query = "UPDATE users SET 
      first_name = '$first_name', 
      last_name = '$last_name', 
      bio = '$bio',
      password = '$hashed_password'
      WHERE id = " . intval($_SESSION['id']);
  }

  if (mysqli_query($conn, $update_query)) {
    header("Location: settings.php?success=1");
    exit;
  } else {
    $error = "Update failed: " . mysqli_error($conn);
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Macan Weblog</title>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f9f9f9; color: #333; }
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
  <h2>Update Profile</h2>

  <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <img src= "<?'/statics/images/user.jpg' . md5($_SESSION['user_id']) . '.jpg';?>" onerror="this.src='/statics/images/user.png'"><img><a htr
  <form method="post" action="">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($row['username'] ?? '') ?>" disabled>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($row['email'] ?? '') ?>" disabled>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" value="<?= htmlspecialchars($row['password'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label>First Name</label>
      <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label>Last Name</label>
      <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label>Bio</label>
      <textarea name="bio" rows="4"><?= htmlspecialchars($row['bio'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
      <button type="submit">Save Changes</button>
    </div>
  </form>
</div>

<footer>
  <p>&copy; 2025 My Weblog. All rights reserved.</p>
</footer>

</body>
</html>
