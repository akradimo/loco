<?php
include '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>خطای سرور</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">خطای سرور</h2>
        <p class="text-center">خطایی در سرور رخ داده است. لطفاً بعداً تلاش کنید.</p>
        <p class="text-center"><a href="/loco/pages/list_errors.php" class="btn btn-secondary">بازگشت به صفحه اصلی</a></p>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>