<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection(); // اتصال به دیتابیس

// دریافت لیست خطاها
$stmt = $conn->prepare("SELECT errors.*, users.fullname, error_groups.group_name 
                        FROM errors 
                        JOIN users ON errors.created_by = users.id 
                        JOIN error_groups ON errors.group_id = error_groups.id");
$stmt->execute();
$errors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست خطاها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لیست خطاها</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>کد خطا</th>
                    <th>نام خطا</th>
                    <th>گروه</th>
                    <th>توضیحات</th>
                    <th>استان</th>
                    <th>شهر</th>
                    <th>ایستگاه</th>
                    <th>تاریخ ایجاد</th>
                    <th>ایجاد کننده</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($errors as $error): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                        <td><?php echo htmlspecialchars($error['error_name']); ?></td>
                        <td><?php echo htmlspecialchars($error['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($error['description']); ?></td>
                        <td><?php echo htmlspecialchars($error['province']); ?></td>
                        <td><?php echo htmlspecialchars($error['city']); ?></td>
                        <td><?php echo htmlspecialchars($error['station']); ?></td>
                        <td><?php echo htmlspecialchars($error['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($error['fullname']); ?></td>
                        <td>
                            <a href="/loco/pages/edit_error.php?id=<?php echo $error['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="/loco/includes/delete_error.php?id=<?php echo $error['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>