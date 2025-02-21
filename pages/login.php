<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // بررسی وجود کاربر
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ذخیره اطلاعات کاربر در session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['can_add_error'] = $user['can_add_error'];
        $_SESSION['can_edit_error'] = $user['can_edit_error'];
        $_SESSION['can_delete_error'] = $user['can_delete_error'];
        $_SESSION['can_add_group'] = $user['can_add_group'];
        $_SESSION['can_edit_group'] = $user['can_edit_group'];
        $_SESSION['can_view_errors'] = $user['can_view_errors'];

        // هدایت به داشبورد
        header("Location: /loco/pages/dashboard.php");
        exit();
    } else {
        $error = "نام کاربری یا رمز عبور اشتباه است.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به سیستم</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ورود به سیستم</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="/loco/pages/login.php" method="post">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">ورود</button>
        </form>
        <p class="mt-3">حساب کاربری ندارید؟ <a href="/loco/pages/register.php">ثبت‌نام کنید</a></p>
    </div>
</body>
</html>