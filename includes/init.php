<?php
// تنظیمات اتصال به دیتابیس
$host = 'localhost';
$dbname = 'loco';
$username = 'root';
$password = '';

try {
    // اتصال به دیتابیس
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ایجاد دیتابیس اگر وجود نداشته باشد
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->exec("USE $dbname");

    // ایجاد جدول کاربران
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fullname VARCHAR(100) NOT NULL,
            national_code VARCHAR(10) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            profile_image VARCHAR(255),
            is_admin BOOLEAN DEFAULT FALSE,
            can_add_error BOOLEAN DEFAULT FALSE,
            can_edit_error BOOLEAN DEFAULT FALSE,
            can_delete_error BOOLEAN DEFAULT FALSE,
            can_add_group BOOLEAN DEFAULT FALSE,
            can_edit_group BOOLEAN DEFAULT FALSE,
            can_view_errors BOOLEAN DEFAULT FALSE,
            personnel_code VARCHAR(50),
            station VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // ایجاد جدول گروه‌ها
    $conn->exec("
        CREATE TABLE IF NOT EXISTS error_groups (
            id INT AUTO_INCREMENT PRIMARY KEY,
            group_name VARCHAR(100) NOT NULL UNIQUE,
            parent_group_id INT DEFAULT NULL,
            FOREIGN KEY (parent_group_id) REFERENCES error_groups(id)
        )
    ");

    // ایجاد جدول خطاها
    $conn->exec("
        CREATE TABLE IF NOT EXISTS errors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            error_code VARCHAR(50) NOT NULL,
            error_name VARCHAR(100) NOT NULL,
            group_id INT,
            subgroup_id INT DEFAULT NULL,
            description TEXT,
            province VARCHAR(50),
            city VARCHAR(50),
            station VARCHAR(100),
            created_at DATE,
            attachment VARCHAR(255),
            created_by INT,
            FOREIGN KEY (group_id) REFERENCES error_groups(id),
            FOREIGN KEY (subgroup_id) REFERENCES error_groups(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        )
    ");

    // ایجاد جدول تاریخچه تغییرات
    $conn->exec("
        CREATE TABLE IF NOT EXISTS error_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            error_id INT,
            user_id INT,
            action VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (error_id) REFERENCES errors(id),
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");

    // افزودن یک کاربر مدیر سیستم پیش‌فرض
    $stmt = $conn->prepare("INSERT INTO users (fullname, national_code, username, password, is_admin, can_add_error, can_edit_error, can_delete_error, can_add_group, can_edit_group, can_view_errors, personnel_code, station) VALUES (:fullname, :national_code, :username, :password, :is_admin, :can_add_error, :can_edit_error, :can_delete_error, :can_add_group, :can_edit_group, :can_view_errors, :personnel_code, :station)");
    $stmt->execute([
        'fullname' => 'مدیر سیستم',
        'national_code' => '1234567890',
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT), // رمز عبور: admin123
        'is_admin' => 1,
        'can_add_error' => 1,
        'can_edit_error' => 1,
        'can_delete_error' => 1,
        'can_add_group' => 1,
        'can_edit_group' => 1,
        'can_view_errors' => 1,
        'personnel_code' => '001',
        'station' => 'تهران'
    ]);

    // افزودن چند گروه پیش‌فرض
    $stmt = $conn->prepare("INSERT INTO error_groups (group_name) VALUES (:group_name)");
    $groups = ['گروه ۱', 'گروه ۲', 'گروه ۳'];
    foreach ($groups as $group) {
        $stmt->execute(['group_name' => $group]);
    }

    // افزودن چند زیرگروه پیش‌فرض
    $stmt = $conn->prepare("INSERT INTO error_groups (group_name, parent_group_id) VALUES (:group_name, :parent_group_id)");
    $subgroups = [
        ['زیرگروه ۱-۱', 1], // زیرگروه ۱-۱ متعلق به گروه ۱
        ['زیرگروه ۱-۲', 1], // زیرگروه ۱-۲ متعلق به گروه ۱
        ['زیرگروه ۲-۱', 2], // زیرگروه ۲-۱ متعلق به گروه ۲
    ];
    foreach ($subgroups as $subgroup) {
        $stmt->execute(['group_name' => $subgroup[0], 'parent_group_id' => $subgroup[1]]);
    }

    echo "دیتابیس و جداول با موفقیت ایجاد شدند. کاربر مدیر سیستم با نام کاربری 'admin' و رمز عبور 'admin123' اضافه شد.";
} catch (PDOException $e) {
    echo "خطا: " . $e->getMessage();
}
?>