<?php
if (!function_exists('checkAuth')) {
    function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /loco/pages/login.php");
            exit();
        }

        $_SESSION['is_admin'] = $_SESSION['is_admin'] ?? false;
        $_SESSION['fullname'] = $_SESSION['fullname'] ?? '';
    }
}
?>