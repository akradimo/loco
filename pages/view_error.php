<?php
include '../includes/auth.php';
include '../includes/db.php';

$error_id = $_GET['id'] ?? null;
if (!$error_id) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت اطلاعات خطا
$stmt = $conn->prepare("SELECT errors.*, users.fullname, error_groups.group_name 
                        FROM errors 
                        JOIN users ON errors.created_by = users.id 
                        JOIN error_groups ON errors.group_id = error_groups.id 
                        WHERE errors.id = :error_id");
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
                <h6 class="card-subtitle mb-2 text-muted">نام خطا: <?php echo htmlspecialchars($error['error_name']); ?></h6>
                <p class="card-text">گروه: <?php echo htmlspecialchars($error['group_name']); ?></p>
                <p class="card-text">توضیحات: <?php echo htmlspecialchars($error['description']); ?></p>
                <p class="card-text">استان: <?php echo htmlspecialchars($error['province']); ?></p>
                <p class="card-text">شهر: <?php echo htmlspecialchars($error['city']); ?></p>
                <p class="card-text">ایستگاه: <?php echo htmlspecialchars($error['station']); ?></p>
                <p class="card-text">تاریخ ایجاد: <?php echo htmlspecialchars($error['created_at']); ?></p>
                <p class="card-text">ایجاد کننده: <?php echo htmlspecialchars($error['fullname']); ?></p>
                <?php if ($error['attachment']): ?>
                    <p class="card-text">فایل پیوست: <a href="/loco/uploads/<?php echo htmlspecialchars($error['attachment']); ?>" target="_blank">دانلود</a></p>
                <?php endif; ?>
            </div>
        </div>
        <a href="/loco/pages/list_errors.php" class="btn btn-secondary mt-3">بازگشت</a>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>