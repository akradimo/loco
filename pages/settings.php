<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند تنظیمات را تغییر دهد)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setting_name = sanitizeInput($_POST['setting_name']);
    $setting_value = sanitizeInput($_POST['setting_value']);

    // بررسی وجود تنظیمات
    $stmt = $conn->prepare("SELECT id FROM settings WHERE setting_name = :setting_name");
    $stmt->bindParam(':setting_name', $setting_name);
    $stmt->execute();
    $existingSetting = $stmt->fetch();

    if ($existingSetting) {
        // به‌روزرسانی تنظیمات موجود
        $stmt = $conn->prepare("UPDATE settings SET setting_value = :setting_value WHERE setting_name = :setting_name");
    } else {
        // افزودن تنظیمات جدید
        $stmt = $conn->prepare("INSERT INTO settings (setting_name, setting_value) VALUES (:setting_name, :setting_value)");
    }
    $stmt->bindParam(':setting_name', $setting_name);
    $stmt->bindParam(':setting_value', $setting_value);
    $stmt->execute();

    redirect('/loco/pages/settings.php');
}

// دریافت تنظیمات
$stmt = $conn->prepare("SELECT * FROM settings");
$stmt->execute();
$settings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تنظیمات</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">تنظیمات</h2>
        <form method="POST">
            <div class="form-group">
                <label for="setting_name">نام تنظیمات</label>
                <input type="text" class="form-control" id="setting_name" name="setting_name" required>
            </div>
            <div class="form-group">
                <label for="setting_value">مقدار تنظیمات</label>
                <input type="text" class="form-control" id="setting_value" name="setting_value" required>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تنظیمات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>