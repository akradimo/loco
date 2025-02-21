<?php
include '../includes/auth.php';

if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

$error_id = $_GET['error_id'] ?? null;
if (!$error_id) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت تاریخچه تغییرات خطا
$stmt = $conn->prepare("SELECT error_log.*, users.fullname, users.national_code FROM error_log LEFT JOIN users ON error_log.user_id = users.id WHERE error_log.error_id = :error_id ORDER BY error_log.created_at DESC");
$stmt->execute(['error_id' => $error_id]);
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تاریخچه تغییرات خطا</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">تاریخچه تغییرات خطا</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>تاریخ</th>
                    <th>کاربر</th>
                    <th>کد ملی</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($log['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($log['national_code']); ?></td>
                        <td><?php echo htmlspecialchars($log['action']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>