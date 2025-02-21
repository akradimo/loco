<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $personal_code = $_POST['personal_code'];

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
            INSERT INTO users (username, password, fullname, personal_code) 
            VALUES (:username, :password, :fullname, :personal_code)
        ");
        $stmt->execute([
            'username' => $username,
            'password' => $hashed_password,
            'fullname' => $fullname,
            'personal_code' => $personal_code
        ]);

        header("Location: /loco/pages/login.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ثبت‌نام</h2>
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
            <button type="submit" class="btn btn-primary">ثبت‌نام</button>
        </form>
    </div>
</body>
</html>