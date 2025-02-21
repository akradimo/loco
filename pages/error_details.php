<?php
include '../includes/auth.php';

if (!$_SESSION['can_view_errors']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

$error_id = $_GET['id'] ?? null;
if (!$error_id) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت اطلاعات خطا
$stmt = $conn->prepare("SELECT errors.*, error_groups.group_name, users.fullname, users.national_code FROM errors LEFT JOIN error_groups ON errors.group_id = error_groups.id LEFT JOIN users ON errors.created_by = users.id WHERE errors.id = :error_id");
$stmt->execute(['error_id' => $error_id]);
$error = $stmt->fetch();

if (!$error) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جزئیات خطا</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">جزئیات خطا</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">کد خطا: <?php echo htmlspecialchars($error['error_code']); ?></h5>
                <p class="card-text">نام خطا: <?php echo htmlspecialchars($error['error_name']); ?></p>
                <p class="card-text">گروه: <?php echo htmlspecialchars($error['group_name']); ?></p>
                <p class="card-text">توضیحات: <?php echo htmlspecialchars($error['description']); ?></p>
                <p class="card-text">استان: <?php echo htmlspecialchars($error['province']); ?></p>
                <p class="card-text">شهر: <?php echo htmlspecialchars($error['city']); ?></p>
                <p class="card-text">ایستگاه: <?php echo htmlspecialchars($error['station']); ?></p>
                <p class="card-text">تاریخ ایجاد: <?php echo htmlspecialchars($error['created_at']); ?></p>
                <p class="card-text">ایجاد شده توسط: <?php echo htmlspecialchars($error['fullname']); ?> (کد ملی: <?php echo htmlspecialchars($error['national_code']); ?>)</p>
                <?php if ($error['attachment']): ?>
                    <p class="card-text">فایل پیوست:</p>
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $error['attachment'])): ?>
                        <img src="/loco/uploads/<?php echo htmlspecialchars($error['attachment']); ?>" class="img-fluid" alt="پیوست">
                    <?php elseif (preg_match('/\.(mp4|webm|ogg)$/i', $error['attachment'])): ?>
                        <video controls class="img-fluid">
                            <source src="/loco/uploads/<?php echo htmlspecialchars($error['attachment']); ?>" type="video/mp4">
                            مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                        </video>
                    <?php else: ?>
                        <a href="/loco/uploads/<?php echo htmlspecialchars($error['attachment']); ?>" target="_blank">دانلود فایل</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>