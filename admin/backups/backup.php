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

<?php include '../../header.php'; ?>

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