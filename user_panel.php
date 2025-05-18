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
    <h1>Welcome to My Weblog</h1>
    <p>Thoughts, stories, and ideas.</p>
  </header>

  <nav>
    <ul>
      <li><a href="#">Panel</a></li>
      <li><a href="#">Write</a></li>
      <li><a href="#">Posts</a></li>
      <li><a href="settings.php">Settings</a></li>
      <li>(<?php echo $_SESSION['username']?>)<a href="/logout.php">Logout</a></li>
    </ul>
  </nav>

  <div class="container">
    <h2>Latest Post</h2>
    <p>This is where your latest blog post would go. You can update this section dynamically with PHP or another backend language.</p>
  </div>
<?php
} else { ?>
  <P>Redirecting you to login page... </p>
  <script>

    setTimeout(function () {
      window.location.href = "/login.php"; 
      document.body.innerHTML = '<P>HI FUCK YOU</P>';
    }, 3000);

  </script>

<?php } ?>

  <footer>
    <p>&copy; 2025 My Weblog. All rights reserved.</p>
  </footer>

</body>
</html>