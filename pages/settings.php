<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند تنظیمات را تغییر دهد)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // اعمال تغییرات تنظیمات
    $setting_name = sanitizeInput($_POST['setting_name']);
    $setting_value = sanitizeInput($_POST['setting_value']);

    $stmt = $conn->prepare("UPDATE settings SET setting_value = :setting_value WHERE setting_name = :setting_name");
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
            <?php foreach ($settings as $setting): ?>
                <div class="form-group">
                    <label for="<?php echo $setting['setting_name']; ?>"><?php echo htmlspecialchars($setting['setting_name']); ?></label>
                    <input type="text" class="form-control" id="<?php echo $setting['setting_name']; ?>" name="setting_value" value="<?php echo htmlspecialchars($setting['setting_value']); ?>" required>
                    <input type="hidden" name="setting_name" value="<?php echo $setting['setting_name']; ?>">
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>