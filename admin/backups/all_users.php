<?php
include 'access.php'; // چک دسترسی
include '../../db.php'; // اصلاح مسیر

$sql = "SELECT id, username, email, first_name, last_name, is_admin FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-12">
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<h2 class='text-2xl font-bold text-gray-800 mb-4'>All Users</h2>";
            echo "<ul class='list-disc pl-5'>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>ID: " . htmlspecialchars($row['id']) . " - Username: " . htmlspecialchars($row['username']) . 
                     " - Email: " . htmlspecialchars($row['email']) . 
                     " - Admin: " . ($row['is_admin'] ? 'Yes' : 'No') . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='text-gray-800'>No users found.</p>";
        }
        ?>
    </div>
</body>
</html>