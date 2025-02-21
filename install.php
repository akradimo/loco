<?php
// اتصال به سرور دیتابیس (بدون انتخاب دیتابیس خاص)
$host = 'localhost';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ایجاد دیتابیس
    $conn->exec("CREATE DATABASE IF NOT EXISTS loco CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "دیتابیس 'loco' ایجاد شد.<br>";

    // انتخاب دیتابیس
    $conn->exec("USE loco");

    // ایجاد جداول
    $sql = file_get_contents('includes/database.sql');
    $conn->exec($sql);
    echo "جداول ایجاد شدند.<br>";

    // افزودن کاربر پیش‌فرض (ادمین)
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_DEFAULT); // رمز عبور پیش‌فرض
    $fullname = 'مدیر سیستم';
    $is_admin = 1;

    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, is_admin) VALUES (:username, :password, :fullname, :is_admin)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':is_admin', $is_admin);
    $stmt->execute();
    echo "کاربر پیش‌فرض (ادمین) ایجاد شد.<br>";

    echo "نصب با موفقیت انجام شد. <a href='/loco/pages/login.php'>ورود به سیستم</a>";
} catch (PDOException $e) {
    die("خطا در نصب: " . $e->getMessage());
}
?>