<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند دسترسی اعطا کند)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // اعطای دسترسی به کاربر
    $stmt = $conn->prepare("UPDATE users SET can_add_error = 1 WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    redirect('/loco/pages/list_users.php');
}
?>