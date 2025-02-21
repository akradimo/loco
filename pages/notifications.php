<?php
include '../includes/auth.php';
include '../includes/db.php';

// دریافت اطلاعیه‌ها
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$notifications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اطلاعیه‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">اطلاعیه‌ها</h2>
        <div class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($notification['title']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($notification['message']); ?></p>
                    <small><?php echo htmlspecialchars($notification['created_at']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>