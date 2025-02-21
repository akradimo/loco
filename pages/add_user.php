<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT);
    $fullname = sanitizeInput($_POST['fullname']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, is_admin) VALUES (:username, :password, :fullname, :is_admin)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':is_admin', $is_admin);
    $stmt->execute();

    redirect('/loco/pages/list_users.php');
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن کاربر</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">افزودن کاربر</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">نام کامل</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="is_admin">مدیر سیستم</label>
                <input type="checkbox" id="is_admin" name="is_admin">
            </div>
            <button type="submit" class="btn btn-primary">افزودن کاربر</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>