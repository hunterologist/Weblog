<?php
session_start();
$page_title = "Logout";
include 'header.php';

// پاک کردن session
$_SESSION = array();
// عمداً session ID بازسازی نمی‌شه برای تمرین Session Fixation
session_destroy();
?>

<section class="max-w-md mx-auto text-center py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Logged Out</h1>
    <p class="text-lg text-gray-600 mb-4">You have been successfully logged out.</p>
    <p class="text-gray-600">Redirecting you to login page...</p>
    <script>
        setTimeout(() => {
            window.location.href = '/login.php';
        }, 3000);
    </script>
</section>

<?php include 'footer.php'; ?>