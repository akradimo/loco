<?php
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit();
    }
}

if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return $_SESSION['is_admin'] ?? false;
    }
}
?><?php
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit();
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return $_SESSION['is_admin'] ?? false;
    }
}
?>