<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /loco/pages/login.php");
    exit();
}
// بررسی دسترسی‌ها
if (!isset($_SESSION['can_delete_error'])) {
    $_SESSION['can_delete_error'] = false; // پیش‌فرض غیرفعال
}

if (!isset($_SESSION['can_edit_error'])) {
    $_SESSION['can_edit_error'] = false; // پیش‌فرض غیرفعال
}
?>
