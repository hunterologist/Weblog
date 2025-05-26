<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hunterologist Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for hover effects and animations */
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
<body class="bg-gray-100 font-sans">
    <header class="bg-blue-600 text-white shadow-md">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold">Hunterologist Blog</div>
            <ul class="flex space-x-6">
                <li><a href="index.php" class="nav-link px-3 py-2 rounded transition duration-300">Index</a></li>
                <li><a href="/all_posts.php" class="nav-link px-3 py-2 rounded transition duration-300">All Posts</a></li>
                <li><a href="/user_panel.php" class="nav-link px-3 py-2 rounded transition duration-300">User Panel</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section class="hero-section text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Welcome to Hunterologist Blog</h1>
            <p class="text-lg text-gray-600 mb-8">Your platform to share ideas, stories, and insights with the world.</p>
            <a href="/all_posts.php" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Explore Posts</a>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 Hunterologist Weblog System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Simple JavaScript for navbar toggle on mobile (optional)
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.querySelector('nav ul');
            const toggleButton = document.createElement('button');
            toggleButton.innerHTML = '☰';
            toggleButton.className = 'md:hidden text-white text-2xl focus:outline-none';
            document.querySelector('nav').prepend(toggleButton);

            toggleButton.addEventListener('click', () => {
                nav.classList.toggle('hidden');
                nav.classList.toggle('flex');
                nav.classList.toggle('flex-col');
                nav.classList.toggle('absolute');
                nav.classList.toggle('bg-blue-600');
                nav.classList.toggle('w-full');
                nav.classList.toggle('top-16');
                nav.classList.toggle('left-0');
            });

            // Hide nav by default on mobile
            nav.classList.add('hidden', 'md:flex');
        });
    </script>
</body>
</html>