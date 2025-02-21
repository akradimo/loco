<?php
include '../includes/auth.php';
include '../includes/db.php';

$error_id = $_GET['id'] ?? null;
if (!$error_id) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت تاریخچه تغییرات خطا
$stmt = $conn->prepare("
    SELECT eh.*, u.fullname 
    FROM error_history eh 
    JOIN users u ON eh.user_id = u.id 
    WHERE eh.error_id = :error_id 
    ORDER BY eh.change_date DESC
");
$stmt->execute(['error_id' => $error_id]);
$history = $stmt->fetchAll();
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>تاریخ تغییر</th>
                    <th>نوع تغییر</th>
                    <th>کاربر</th>
                    <th>جزئیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['change_date']); ?></td>
                        <td><?php echo htmlspecialchars($record['change_type']); ?></td>
                        <td><?php echo htmlspecialchars($record['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($record['change_details']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/loco/pages/list_errors.php" class="btn btn-secondary">بازگشت</a>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>