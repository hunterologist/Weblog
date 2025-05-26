<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Hunter Weblog System'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/statics/style.css">
    <style>
        .nav-link:hover {
            background-color: #e5e7eb;
            transform: translateY(-2px);
        }
        .hero-section {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">
    <header class="bg-blue-600 text-white shadow-md w-full">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center w-full">
            <div class="text-2xl font-bold">Hunter Weblog</div>
            <ul class="flex space-x-6 hidden md:flex flex-wrap">
                <li><a href="index.php" class="nav-link px-3 py-2 rounded transition duration-300">Main</a></li>
                <li><a href="user_panel.php" class="nav-link px-3 py-2 rounded transition duration-300">Panel</a></li>
                <li><a href="write_post.php" class="nav-link px-3 py-2 rounded transition duration-300">Write</a></li>
                <li><a href="my_posts.php" class="nav-link px-3 py-2 rounded transition duration-300">Posts</a></li>
                <li><a href="settings.php" class="nav-link px-3 py-2 rounded transition duration-300">Settings</a></li>
                <?php if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true): ?>
                    <li><span class="text-gray-200 px-3 py-2">(<?php echo htmlspecialchars($_SESSION['username']); ?>)</span>
                        <a href="logout.php" class="nav-link px-3 py-2 rounded transition duration-300">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-link px-3 py-2 rounded transition duration-300">Login</a></li>
                    <li><a href="register.php" class="nav-link px-3 py-2 rounded transition duration-300">Register</a></li>
                <?php endif; ?>
            </ul>
            <button class="md:hidden text-white text-2xl focus:outline-none">☰</button>
        </nav>
    </header>
    <main class="container mx-auto px-4 py-12 flex-1">
