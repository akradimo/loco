<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();
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
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">خطاها</h5>
                        <p class="card-text">مدیریت خطاهای سیستم.</p>
                        <a href="/loco/pages/list_errors.php" class="btn btn-primary">مشاهده خطاها</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">گروه‌ها</h5>
                        <p class="card-text">مدیریت گروه‌های خطا.</p>
                        <a href="/loco/pages/list_groups.php" class="btn btn-primary">مشاهده گروه‌ها</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">کاربران</h5>
                        <p class="card-text">مدیریت کاربران سیستم.</p>
                        <a href="/loco/pages/list_users.php" class="btn btn-primary">مشاهده کاربران</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>