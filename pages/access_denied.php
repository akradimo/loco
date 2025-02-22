<?php
include '../includes/auth.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دسترسی ممنوع</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">دسترسی ممنوع</h2>
        <p class="text-center">شما مجوز دسترسی به این صفحه را ندارید.</p>
        <div class="text-center">
            <a href="/loco/pages/dashboard.php" class="btn btn-primary">بازگشت به داشبورد</a>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>