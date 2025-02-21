<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // بررسی وجود کاربر با ایمیل وارد شده
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // ایجاد توکن بازیابی رمز عبور
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $conn->prepare("
            INSERT INTO password_resets (user_id, token, expires_at) 
            VALUES (:user_id, :token, :expires_at)
        ");
        $stmt->execute([
            'user_id' => $user['id'],
            'token' => $token,
            'expires_at' => $expires_at
        ]);

        // ارسال ایمیل بازیابی رمز عبور
        // این بخش نیاز به پیاده‌سازی ارسال ایمیل دارد.
        $success_message = "ایمیلی حاوی لینک بازیابی رمز عبور به آدرس شما ارسال شد.";
    } else {
        $error_message = "ایمیل وارد شده در سیستم وجود ندارد.";
    }
}
?>