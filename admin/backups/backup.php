<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'access.php';
include '../../db.php';
include 'mysql-backup.php';

// تنظیم مسیر بک‌آپ
$backupPath = __DIR__ . '/backups/';
if (!file_exists($backupPath)) {
    if (!mkdir($backupPath, 0777, true) && !is_dir($backupPath)) {
        die("Failed to create backup directory: $backupPath. Check server permissions.");
    }
    chmod($backupPath, 0775);
}

if (!is_writable($backupPath)) {
    die("Backup directory is not writable: $backupPath. Check permissions.");
}

if (isset($_POST['create_backup'])) {
    unset($_SESSION['backup_message']);
    new MySQLBackup($conn, $backupPath); // استفاده از $conn به جای متغیرها
    header("Location: backup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Hunter Weblog System'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/statics/style.css">
    <style>
        .nav-link {
            color: #ffffff; /* سفید برای لینک‌ها */
        }
        .nav-link:hover {
            background-color: #e5e7eb;
            transform: translateY(-2px);
            color: #1e40af; /* آبی تیره برای کنتراست تو hover */
        }
        .hero-section {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .footer-content {
            padding: 0 1rem;
        }

            /* تنظیمات برای نگه داشتن فوتر پایین صفحه */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* حداقل ارتفاع کل صفحه */
        }
        main {
            flex: 1 0 auto; /* main محتوای اصلی رو پر می‌کنه */
        }
        footer {
            flex-shrink: 0; /* فوتر جمع نمی‌شه */
            width: 100%;
            background-color: #1f2937; /* خاکستری تیره */
            transition: transform 0.3s ease-in-out; /* انیمیشن برای حرکت */
        }
        .footer-hidden {
            transform: translateY(100%); /* مخفی کردن فوتر به پایین */
        }
        .footer-visible {
            transform: translateY(0); /* نمایش فوتر */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">
    <header class="bg-blue-600 text-white shadow-md w-full">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center w-full">
            <div class="text-2xl font-bold">Hunter Weblog</div>
            <ul class="flex space-x-6 hidden md:flex flex-wrap">
                <li><a href="/index.php" class="nav-link px-3 py-2 rounded transition duration-300">Main</a></li>
                <li><a href="/user_panel.php" class="nav-link px-3 py-2 rounded transition duration-300">Panel</a></li>
                <li><a href="/write_post.php" class="nav-link px-3 py-2 rounded transition duration-300">Write</a></li>
                <li><a href="/my_posts.php" class="nav-link px-3 py-2 rounded transition duration-300">Posts</a></li>
                <li><a href="/settings.php" class="nav-link px-3 py-2 rounded transition duration-300">Settings</a></li>
                <?php if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true): ?>
                    <li><span class="text-gray-200 px-3 py-2">(<?php echo htmlspecialchars($_SESSION['username']); ?>)</span>
                        <a href="/logout.php" class="nav-link px-3 py-2 rounded transition duration-300">Logout</a></li>
                <?php else: ?>
                    <li><a href="/login.php" class="nav-link px-3 py-2 rounded transition duration-300">Login</a></li>
                    <li><a href="/register.php" class="nav-link px-3 py-2 rounded transition duration-300">Register</a></li>
                <?php endif; ?>
            </ul>
            <button class="md:hidden text-white text-2xl focus:outline-none">☰</button>
        </nav>
    </header>

<main class="container mx-auto px-4 py-12">
    <section class="max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Create Backup</h2>
        <?php if (isset($_SESSION['backup_message'])): ?>
            <p class="message success"><?php echo $_SESSION['backup_message']; unset($_SESSION['backup_message']); ?></p>
        <?php endif; ?>
        <form method="POST">
            <button type="submit" name="create_backup" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Create Backup</button>
        </form>
        <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">Existing Backups</h3>
        <?php
        $backup_files = glob($backupPath . '*.sql');
        if ($backup_files) {
            echo "<ul class='list-disc pl-5'>";
            foreach ($backup_files as $file) {
                $filename = basename($file);
                echo "<li><a href='/admin/backups/backups/$filename' class='text-blue-600 hover:underline'>$filename</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No backups available.</p>";
        }
        ?>
    </section>
</main>

<footer class="bg-gray-800 text-white py-6">
    <div class="footer-content text-center">
        <p>© 2025 Hunterologist Weblog System. All rights reserved.</p>
        <div class="mt-2">
            <a href="#" class="text-blue-300 hover:text-blue-400 mx-2">Twitter</a>
            <a href="#" class="text-blue-300 hover:text-blue-400 mx-2">Facebook</a>
            <a href="#" class="text-blue-300 hover:text-blue-400 mx-2">Instagram</a>
        </div>
    </div>
</footer>

</body>
</html>