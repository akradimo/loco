<?php
if (!function_exists('checkAuth')) {
    function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // اگر کاربر لاگین نکرده باشد، به صفحه لاگین هدایت می‌شود
        if (!isset($_SESSION['user_id'])) {
            header("Location: /loco/pages/login.php");
            exit();
        }

        // تنظیم مقادیر پیش‌فرض برای session
        $_SESSION['is_admin'] = $_SESSION['is_admin'] ?? false;
        $_SESSION['fullname'] = $_SESSION['fullname'] ?? '';
        $_SESSION['can_add_error'] = $_SESSION['can_add_error'] ?? false; // افزودن مجوز اضافه کردن خطا
    }
}
?>