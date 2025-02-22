<?php
include 'auth.php';
checkAuth();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/loco/pages/dashboard.php">LOCO</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/loco/pages/list_errors.php">لیست خطاها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/loco/pages/list_groups.php">لیست گروه‌ها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/loco/pages/list_users.php">لیست کاربران</a>
            </li>
            <?php if ($_SESSION['is_admin'] || $_SESSION['can_add_error']): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/add_error.php">افزودن خطا</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['is_admin']): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/add_group.php">افزودن گروه</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/activity_log.php">لاگ فعالیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/settings.php">تنظیمات</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="/loco/includes/logout.php">خروج</a>
            </li>
        </ul>
    </div>
</nav>