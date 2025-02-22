<?php
include '../includes/db.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT);
    $fullname = sanitizeInput($_POST['fullname']);
    $personal_code = sanitizeInput($_POST['personal_code']);

    $conn = getDbConnection();
    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, personal_code) VALUES (:username, :password, :fullname, :personal_code)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':personal_code', $personal_code);
    $stmt->execute();

    redirect('/loco/pages/login.php');
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت نام</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ثبت نام</h2>
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
                <label for="personal_code">کد پرسنلی</label>
                <input type="text" class="form-control" id="personal_code" name="personal_code">
            </div>
            <button type="submit" class="btn btn-primary">ثبت نام</button>
        </form>
    </div>
</body>
</html>