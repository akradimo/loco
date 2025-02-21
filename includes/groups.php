<?php
session_start();
include 'db.php';

if ($_GET['action'] === 'add') {
    $group_name = $_POST['group_name'];
    $parent_group_id = $_POST['parent_group_id'] ?? null;

    // افزودن گروه جدید
    $stmt = $conn->prepare("INSERT INTO error_groups (group_name, parent_group_id) VALUES (:group_name, :parent_group_id)");
    $stmt->execute(['group_name' => $group_name, 'parent_group_id' => $parent_group_id]);

    // بازگرداندن نتیجه به صورت JSON
    echo json_encode(['success' => true, 'group_id' => $conn->lastInsertId()]);
    exit();
} elseif ($_GET['action'] === 'delete') {
    $group_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM error_groups WHERE id = :id");
    $stmt->execute(['id' => $group_id]);

    header("Location: /loco/pages/manage_groups.php?success=1");
    exit();
}
?>