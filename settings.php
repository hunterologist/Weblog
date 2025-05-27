<?php
session_start();
$page_title = "Settings";
include 'header.php';
include 'db.php';

if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];
$image_path = file_exists(__DIR__ . "/statics/images/" . md5($user_id) . ".png")
    ? "/statics/images/" . md5($user_id) . ".png"
    : "/statics/images/user.jpg";

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $password_change = false;

    if ($password === "") {
        $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio' WHERE `id` = " . $id;
    } else {
        $sql = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `bio` = '$bio', `password` = '$password' WHERE `id` = " . $id;
        $password_change = true;
    }

    try {
        $result = mysqli_query($conn, $sql);
        if ($result === true) {
            if ($password_change) {
                header("Location: logout.php");
            } else {
                header("Location: settings.php?msg=Settings updated successfully");
            }
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$user_query = "SELECT * FROM `users` WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user_information = mysqli_fetch_assoc($user_result);
?>

<section class="max-w-md mx-auto py-12">
    <div class="content-box">
        <h1>Settings</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p class="message success"><?php echo $_GET['msg']; ?></p>
        <?php endif; ?>

        <?php if ($message): ?>
            <p class="message error"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- پروفایل کاربر -->
        <div class="mb-6">
            <h2>Your Profile</h2>
            <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Profile Image" class="w-40 h-40 rounded-full mx-auto mb-4">
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" id="image" name="image" accept="image/*" class="block mx-auto mb-4">
                <button type="submit">Upload Image</button>
            </form>
            <progress id="uploadProgress" max="100" value="0" class="block mx-auto mb-4"></progress>
            <div id="message"></div>
        </div>

        <!-- فرم تنظیمات -->
        <form action="settings.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user_id; ?>">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_information['username']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_information['email']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_information['first_name'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user_information['last_name'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio"><?php echo htmlspecialchars($user_information['bio'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="password">Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" value="">
            </div>

            <input type="submit" value="Update Settings">
        </form>

        <p class="footer"><a href="forget_password.php?username=<?php echo htmlspecialchars($user_information['username']); ?>">Forgot Password?</a></p>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/statics/upload.js"></script>

<?php include 'footer.php'; ?>