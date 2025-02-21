<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // بررسی وجود کاربر با ایمیل وارد شده
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // ارسال ایمیل بازیابی رمز عبور
        // این بخش نیاز به پیاده‌سازی ارسال ایمیل دارد.
        $success_message = "ایمیلی حاوی لینک بازیابی رمز عبور به آدرس شما ارسال شد.";
    } else {
        $error_message = "ایمیل وارد شده در سیستم وجود ندارد.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بازیابی رمز عبور</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">بازیابی رمز عبور</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">ارسال لینک بازیابی</button>
        </form>
    </div>
</body>
</html>