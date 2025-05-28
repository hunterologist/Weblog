<?php
session_start();
$page_title = "Backup System";
include '../header.php';
include 'backups/access.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Backup Management</h2>
        <ul class="list-disc pl-5">
            <li><a href="backups/all_users.php" class="text-blue-600 hover:underline">View All Users</a></li>
            <li><a href="backups/backup.php" class="text-blue-600 hover:underline">Create/Manage Backups</a></li>
        </ul>
    </div>
</body>
</html>