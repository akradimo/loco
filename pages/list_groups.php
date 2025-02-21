<?php
include '../includes/auth.php'; // فقط یک بار فراخوانی شود
include '../includes/db.php';

checkAuth(); // فراخوانی تابع برای بررسی احراز هویت
$conn = getDbConnection();

// دریافت لیست گروه‌ها
$stmt = $conn->prepare("SELECT * FROM error_groups");
$stmt->execute();
$groups = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست گروه‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لیست گروه‌ها</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>نام گروه</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($group['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($group['created_at'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="/loco/pages/edit_group.php?id=<?php echo $group['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="/loco/includes/delete_group.php?id=<?php echo $group['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>