<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند لاگ فعالیت را مشاهده کند)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

// دریافت لاگ فعالیت
$stmt = $conn->prepare("SELECT activity_log.*, users.fullname 
                        FROM activity_log 
                        JOIN users ON activity_log.user_id = users.id 
                        ORDER BY activity_log.created_at DESC");
$stmt->execute();
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لاگ فعالیت</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لاگ فعالیت</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>کاربر</th>
                    <th>فعالیت</th>
                    <th>تاریخ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($log['activity']); ?></td>
                        <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>