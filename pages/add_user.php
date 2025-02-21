<?php
include '../includes/auth.php';

if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $personal_code = $_POST['personal_code'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // بررسی تکراری نبودن نام کاربری
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $error_message = "نام کاربری قبلاً استفاده شده است.";
    } else {
        // ثبت‌نام کاربر جدید
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("
            INSERT INTO users (username, password, fullname, personal_code, is_admin) 
            VALUES (:username, :password, :fullname, :personal_code, :is_admin)
        ");
        $stmt->execute([
            'username' => $username,
            'password' => $hashed_password,
            'fullname' => $fullname,
            'personal_code' => $personal_code,
            'is_admin' => $is_admin
        ]);

        header("Location: /loco/pages/list_users.php?success=1");
        exit();
    }
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
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">نام کامل:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="personal_code">کد پرسنلی:</label>
                <input type="text" class="form-control" id="personal_code" name="personal_code" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                <label class="form-check-label" for="is_admin">مدیر سیستم</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">ذخیره</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>