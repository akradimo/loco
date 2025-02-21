<?php
include 'auth.php'; // فقط یک بار فراخوانی شود
checkAuth(); // فراخوانی تابع برای بررسی احراز هویت
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
            <?php if ($_SESSION['is_admin']): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/loco/pages/add_user.php">افزودن کاربر</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="/loco/includes/logout.php">خروج</a>
            </li>
        </ul>
    </div>
</nav>