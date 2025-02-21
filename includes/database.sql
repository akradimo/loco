-- ایجاد دیتابیس
CREATE DATABASE IF NOT EXISTS loco;
USE loco;

-- جدول کاربران
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    personal_code VARCHAR(20) NOT NULL UNIQUE,
    is_admin TINYINT(1) DEFAULT 0,
    can_edit_error TINYINT(1) DEFAULT 0,
    can_delete_error TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول گروه‌های خطا
CREATE TABLE error_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول خطاها
CREATE TABLE errors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    error_code VARCHAR(50) NOT NULL UNIQUE,
    error_name VARCHAR(100) NOT NULL,
    group_id INT NOT NULL,
    subgroup_id INT,
    description TEXT,
    province VARCHAR(100),
    city VARCHAR(100),
    station VARCHAR(100),
    attachment VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES error_groups(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- جدول تاریخچه تغییرات خطاها
CREATE TABLE error_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    error_id INT NOT NULL,
    user_id INT NOT NULL,
    change_type VARCHAR(50) NOT NULL, -- انواع: اضافه کردن، ویرایش، حذف
    change_details TEXT,
    change_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (error_id) REFERENCES errors(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- درج کاربر پیش‌فرض (ادمین)
INSERT INTO users (username, password, full_name, personal_code, is_admin, can_edit_error, can_delete_error)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدیر سیستم', '1234567890', 1, 1, 1);

-- درج گروه‌های پیش‌فرض
INSERT INTO error_groups (group_name) VALUES ('گروه ۱'), ('گروه ۲'), ('گروه ۳');