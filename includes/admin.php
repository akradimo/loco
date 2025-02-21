<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /loco/pages/login.php");
    exit();
}

$action = $_GET['action'];
$user_id = $_GET['id'];

if ($action == 'approve') {
    // تایید یا لغو تایید کاربر
    $stmt = $conn->prepare("UPDATE users SET is_approved = NOT is_approved WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
} elseif ($action == 'delete') {
    // حذف کاربر
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
} elseif ($action == 'update_permissions') {
    // به‌روزرسانی دسترسی‌ها
    $can_add_error = isset($_POST['can_add_error']) ? 1 : 0;
    $can_edit_error = isset($_POST['can_edit_error']) ? 1 : 0;
    $can_add_group = isset($_POST['can_add_group']) ? 1 : 0;
    $can_edit_group = isset($_POST['can_edit_group']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET can_add_error = :can_add_error, can_edit_error = :can_edit_error, can_add_group = :can_add_group, can_edit_group = :can_edit_group WHERE id = :id");
    $stmt->execute([
        'can_add_error' => $can_add_error,
        'can_edit_error' => $can_edit_error,
        'can_add_group' => $can_add_group,
        'can_edit_group' => $can_edit_group,
        'id' => $user_id
    ]);
}

header("Location: /loco/pages/admin/index.php");
exit();
?>