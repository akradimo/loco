<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /loco/pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $national_code = $_POST['national_code'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $can_add_error = isset($_POST['can_add_error']) ? 1 : 0;
    $can_edit_error = isset($_POST['can_edit_error']) ? 1 : 0;
    $can_add_group = isset($_POST['can_add_group']) ? 1 : 0;
    $can_edit_group = isset($_POST['can_edit_group']) ? 1 : 0;
    $can_view_errors = isset($_POST['can_view_errors']) ? 1 : 0;
    $personnel_code = $_POST['personnel_code'];
    $station = $_POST['station'];

    // بررسی وجود نام کاربری
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $error = "نام کاربری قبلاً استفاده شده است.";
    } else {
        // افزودن کاربر جدید
        $stmt = $conn->prepare("INSERT INTO users (fullname, national_code, username, password, is_admin, can_add_error, can_edit_error, can_add_group, can_edit_group, can_view_errors, personnel_code, station) VALUES (:fullname, :national_code, :username, :password, :is_admin, :can_add_error, :can_edit_error, :can_add_group, :can_edit_group, :can_view_errors, :personnel_code, :station)");
        $stmt->execute([
            'fullname' => $fullname,
            'national_code' => $national_code,
            'username' => $username,
            'password' => $password,
            'is_admin' => $is_admin,
            'can_add_error' => $can_add_error,
            'can_edit_error' => $can_edit_error,
            'can_add_group' => $can_add_group,
            'can_edit_group' => $can_edit_group,
            'can_view_errors' => $can_view_errors,
            'personnel_code' => $personnel_code,
            'station' => $station
        ]);

        header("Location: /loco/pages/add_admin.php?success=1");
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
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">کاربر با موفقیت افزوده شد.</div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="/loco/pages/add_admin.php" method="post">
            <div class="form-group">
                <label for="fullname">نام و نام خانوادگی:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="national_code">کد ملی:</label>
                <input type="text" class="form-control" id="national_code" name="national_code" required>
            </div>
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="personnel_code">کد پرسنلی:</label>
                <input type="text" class="form-control" id="personnel_code" name="personnel_code" required>
            </div>
            <div class="form-group">
                <label for="station">ایستگاه مربوطه:</label>
                <input type="text" class="form-control" id="station" name="station" required>
            </div>
            <div class="form-group">
                <label for="is_admin">مدیر سیستم:</label>
                <input type="checkbox" id="is_admin" name="is_admin">
            </div>
            <div class="form-group">
                <label for="can_add_error">افزودن خطا:</label>
                <input type="checkbox" id="can_add_error" name="can_add_error">
            </div>
            <div class="form-group">
                <label for="can_edit_error">ویرایش خطا:</label>
                <input type="checkbox" id="can_edit_error" name="can_edit_error">
            </div>
            <div class="form-group">
                <label for="can_add_group">افزودن گروه:</label>
                <input type="checkbox" id="can_add_group" name="can_add_group">
            </div>
            <div class="form-group">
                <label for="can_edit_group">ویرایش گروه:</label>
                <input type="checkbox" id="can_edit_group" name="can_edit_group">
            </div>
            <div class="form-group">
                <label for="can_view_errors">مشاهده خطاها:</label>
                <input type="checkbox" id="can_view_errors" name="can_view_errors">
            </div>
            <button type="submit" class="btn btn-primary">افزودن کاربر</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>