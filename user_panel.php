<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="/statics/function.js"> </script>
  <title>Macan Weblog</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    header {
      background-color: #4a90e2;
      color: white;
      padding: 1rem 2rem;
      text-align: center;
    }

    nav {
      background-color: #333;
      padding: 0.5rem;
      text-align: center;
    }

    nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    nav li {
      color: white;
      display: inline;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 0.5rem 1rem;
      transition: background-color 0.3s;
    }

    
    nav a:hover {
      background-color: #444;
      border-radius: 4px;
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      padding: 1rem;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      border-radius: 8px;
    }

    footer {
      text-align: center;
      padding: 1rem;
      color: #777;
      font-size: 0.9rem;
    }

    @media (max-width: 600px) {
      nav a {
        display: block;
        margin: 10px 0;
      }
    }
  </style>
</head>

<?php
session_start();
if (isset ($_SESSION['is_logged']) === true) {
?>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Main</a></li>
                <li><a href="user_panel.php">Panel</a></li>
                <li><a href="wirte_post.php">Write</a></li>
                <li><a href="my_posts.php">Posts</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li>(<?php echo $_SESSION['username']?>) <a href="/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Welcome to the Panel</h1>
            <p>Hello <?php echo $_SESSION['username']; ?></p>
        </section>

    </main>
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
    <p>&copy; 2025 My Weblog. All rights reserved.</p>
  </footer>

</body>
</html>