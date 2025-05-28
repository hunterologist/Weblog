<?php
// session_start(); حذف شد، چون تو backup.php هست

if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['id'])) {
    header("Location: /login.php");
    exit();
}

// چک کردن سطح دسترسی (ادمین)
include '../../db.php';
$user_id = $_SESSION['id'];
$sql = "SELECT is_admin FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['is_admin'] != 1) {
    die("Access denied. You need admin privileges.");
}
?>