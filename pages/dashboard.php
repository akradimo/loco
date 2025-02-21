<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

// دریافت آمار کلی
$stmt = $conn->prepare("SELECT COUNT(*) as total_errors FROM errors");
$stmt->execute();
$total_errors = $stmt->fetch()['total_errors'];

$stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM users");
$stmt->execute();
$total_users = $stmt->fetch()['total_users'];

$stmt = $conn->prepare("SELECT COUNT(*) as total_groups FROM error_groups");
$stmt->execute();
$total_groups = $stmt->fetch()['total_groups'];
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
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">تعداد خطاها</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_errors; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">تعداد کاربران</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_users; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">تعداد گروه‌ها</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_groups; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>