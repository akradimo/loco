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
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            fullname VARCHAR(100) NOT NULL,
            personal_code VARCHAR(20),
            is_admin TINYINT(1) DEFAULT 0,
            can_add_error TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS error_groups (
            id INT AUTO_INCREMENT PRIMARY KEY,
            group_name VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS errors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            error_code VARCHAR(50) NOT NULL UNIQUE,
            error_name VARCHAR(100) NOT NULL,
            group_id INT NOT NULL,
            description TEXT,
            province VARCHAR(100),
            city VARCHAR(100),
            station VARCHAR(100),
            created_by INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (group_id) REFERENCES error_groups(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        );
    ";
    $conn->exec($sql);
    echo "جداول ایجاد شدند.<br>";

    // افزودن کاربر پیش‌فرض (ادمین)
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_DEFAULT); // رمز عبور پیش‌فرض
    $fullname = 'مدیر سیستم';
    $is_admin = 1;
    $can_add_error = 1;

    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, is_admin, can_add_error) VALUES (:username, :password, :fullname, :is_admin, :can_add_error)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':is_admin', $is_admin);
    $stmt->bindParam(':can_add_error', $can_add_error);
    $stmt->execute();
    echo "کاربر پیش‌فرض (ادمین) ایجاد شد.<br>";

    echo "نصب با موفقیت انجام شد. <a href='/loco/pages/login.php'>ورود به سیستم</a>";
} catch (PDOException $e) {
    die("خطا در نصب: " . $e->getMessage());
}
?>