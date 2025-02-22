<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection(); // اتصال به دیتابیس

// دریافت آمار خطاها
$stmt = $conn->prepare("SELECT error_groups.group_name, COUNT(errors.id) AS error_count 
                        FROM errors 
                        JOIN error_groups ON errors.group_id = error_groups.id 
                        GROUP BY error_groups.group_name");
$stmt->execute();
$statistics = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>آمار خطاها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">آمار خطاها</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>گروه</th>
                    <th>تعداد خطاها</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statistics as $stat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($stat['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($stat['error_count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>