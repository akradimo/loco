<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

// دریافت لاگ فعالیت‌ها
$stmt = $conn->prepare("
    SELECT al.*, u.fullname 
    FROM activity_log al 
    JOIN users u ON al.user_id = u.id 
    ORDER BY al.activity_date DESC
");
$stmt->execute();
$activity_logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لاگ فعالیت‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لاگ فعالیت‌ها</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>کاربر</th>
                    <th>فعالیت</th>
                    <th>تاریخ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activity_logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($log['activity']); ?></td>
                        <td><?php echo htmlspecialchars($log['activity_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>