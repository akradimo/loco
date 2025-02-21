<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "رمز عبور و تکرار آن مطابقت ندارند.";
    } else {
        // بررسی اعتبار توکن
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()");
        $stmt->execute(['token' => $token]);
        $reset = $stmt->fetch();

        if ($reset) {
            // بروزرسانی رمز عبور کاربر
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmt->execute([
                'password' => $hashed_password,
                'user_id' => $reset['user_id']
            ]);

            // حذف توکن استفاده شده
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = :token");
            $stmt->execute(['token' => $token]);

            $success_message = "رمز عبور شما با موفقیت تغییر یافت.";
        } else {
            $error_message = "توکن نامعتبر یا منقضی شده است.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تنظیم مجدد رمز عبور</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">تنظیم مجدد رمز عبور</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="token">توکن:</label>
                <input type="text" class="form-control" id="token" name="token" required>
            </div>
            <div class="form-group">
                <label for="new_password">رمز عبور جدید:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">تکرار رمز عبور:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">تغییر رمز عبور</button>
        </form>
    </div>
</body>
</html>