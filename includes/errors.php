<?php
session_start();
include 'db.php';

if ($_GET['action'] === 'add') {
    $error_code = $_POST['error_code'];
    $error_name = $_POST['error_name'];
    $group_id = $_POST['group_id'];
    $subgroup_id = $_POST['subgroup_id'] ?? null;
    $description = $_POST['description'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $created_at = $_POST['created_at'];
    $attachment = $_FILES['attachment']['name'];

    // آپلود فایل ضمیمه
    if ($attachment) {
        $target_dir = "/loco/assets/images/";
        $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
        move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);
    }

    // افزودن خطا به دیتابیس
    $stmt = $conn->prepare("INSERT INTO errors (error_code, error_name, group_id, subgroup_id, description, province, city, created_at, attachment) VALUES (:error_code, :error_name, :group_id, :subgroup_id, :description, :province, :city, :created_at, :attachment)");
    $stmt->execute([
        'error_code' => $error_code,
        'error_name' => $error_name,
        'group_id' => $group_id,
        'subgroup_id' => $subgroup_id,
        'description' => $description,
        'province' => $province,
        'city' => $city,
        'created_at' => $created_at,
        'attachment' => $attachment
    ]);

    header("Location: /loco/pages/errors_list.php?success=1");
    exit();
}
?>