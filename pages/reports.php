<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

// دریافت گزارش خطاها بر اساس گروه
$stmt = $conn->prepare("
    SELECT eg.group_name, COUNT(e.id) as error_count 
    FROM errors e 
    JOIN error_groups eg ON e.group_id = eg.id 
    GROUP BY eg.group_name
");
$stmt->execute();
$error_reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>گزارش‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">گزارش‌ها</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>گروه</th>
                    <th>تعداد خطاها</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($error_reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($report['error_count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>