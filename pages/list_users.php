<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند لیست کاربران را مشاهده کند)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

// دریافت لیست کاربران
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست کاربران</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لیست کاربران</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>نام کاربری</th>
                    <th>نام کامل</th>
                    <th>کد پرسنلی</th>
                    <th>نقش</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($user['personal_code'] ?? 'N/A'); ?></td>
                        <td><?php echo $user['is_admin'] ? 'مدیر' : 'کاربر'; ?></td>
                        <td>
                            <a href="/loco/pages/edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="/loco/includes/delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                            <?php if ($_SESSION['is_admin']): ?>
                                <a href="/loco/pages/grant_access.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">دسترسی</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>