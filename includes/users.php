<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $national_code = $_POST['national_code'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (fullname, national_code, username, password, is_admin, can_add_error, can_edit_error) VALUES (:fullname, :national_code, :username, :password, :is_admin, :can_add_error, :can_edit_error)");
    $stmt->execute([
        'fullname' => $fullname,
        'national_code' => $national_code,
        'username' => $username,
        'password' => $password,
        'is_admin' => ($role === 'admin') ? 1 : 0,
        'can_add_error' => ($role === 'error_manager' || $role === 'admin') ? 1 : 0,
        'can_edit_error' => ($role === 'error_manager' || $role === 'admin') ? 1 : 0
    ]);

    header("Location: /loco/pages/add_admin.php?success=1");
    exit();
}
?>