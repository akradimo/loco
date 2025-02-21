<?php
// جلسه را دوباره شروع نکنید
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سیستم مدیریت خطاهای لوکوموتیو</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
    <style>
        /* استایل‌های سفارشی برای منوهای بازشونده */
        .navbar .dropdown:hover .dropdown-menu {
            display: block;
        }
        .navbar .dropdown-menu {
            margin-top: 0; /* حذف فاصله بین منو و دکمه */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/loco/pages/list_errors.php">سیستم مدیریت خطاهای لوکوموتیو</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- منوی اصلی -->
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/list_errors.php">لیست خطاها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/list_groups.php">لیست گروه‌ها</a>
                </li>
                <?php if ($_SESSION['is_admin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/loco/pages/list_users.php">لیست کاربران</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/dashboard.php">داشبورد</a>
                </li>

                <!-- منوی گزارش‌ها -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button">
                        گزارش‌ها
                    </a>
                    <div class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <a class="dropdown-item" href="/loco/pages/error_statistics.php">آمار خطاها</a>
                        <a class="dropdown-item" href="/loco/pages/activity_log.php">لاگ فعالیت‌ها</a>
                    </div>
                </li>

                <!-- منوی مدیریت -->
                <?php if ($_SESSION['is_admin']): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button">
                            مدیریت
                        </a>
                        <div class="dropdown-menu" aria-labelledby="managementDropdown">
                            <a class="dropdown-item" href="/loco/pages/add_error.php">افزودن خطا</a>
                            <a class="dropdown-item" href="/loco/pages/add_group.php">افزودن گروه</a>
                            <a class="dropdown-item" href="/loco/pages/add_user.php">افزودن کاربر</a>
                            <a class="dropdown-item" href="/loco/pages/settings.php">تنظیمات</a>
                            <a class="dropdown-item" href="/loco/pages/backup.php">پشتیبان‌گیری</a>
                            <a class="dropdown-item" href="/loco/pages/restore.php">بازگردانی پشتیبان</a>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- منوی کاربر -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button">
                        <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'کاربر'); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/loco/pages/profile.php">پروفایل</a>
                        <a class="dropdown-item" href="/loco/pages/change_password.php">تغییر رمز عبور</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/loco/includes/logout.php">خروج</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>