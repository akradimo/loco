<?php
include '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">داشبورد</h2>
        <p>خوش آمدید، <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</p>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>