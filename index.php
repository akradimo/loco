<?php
session_start();
include 'includes/header.php';
?>

<div class="container1">
    <h1 class="home-h1">به برنامه جستجو خطای قطار خوش آمدید</h1>
    <p class="home-p">این برنامه به شما کمک می‌کند تا خطاهای لوکوموتیو را مدیریت کنید.</p>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p >شما وارد شده‌اید. برای مشاهده خطاها، <a href="/loco/pages/dashboard.php">به داشبورد بروید</a>.</p>
    <?php else: ?>
        <p class="home-lo-re">لطفاً برای استفاده از برنامه، <a href="/loco/pages/login.php" class="login-home1">وارد شــویــد</a> یا <a href="/loco/pages/register.php" class="home-register1">ثــبــت نــام کــنــیــد</a>.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>