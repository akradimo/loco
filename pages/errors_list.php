<?php
include '../includes/header.php';
include '../includes/db.php';

// دریافت لیست خطاها از دیتابیس
$stmt = $conn->prepare("SELECT errors.*, error_groups.group_name FROM errors LEFT JOIN error_groups ON errors.group_id = error_groups.id");
$stmt->execute();
$errors = $stmt->fetchAll();
?>

<div class="container">
    <h2>لیست خطاها</h2>
    <input type="text" id="searchError" class="form-control mb-3" placeholder="جستجو در لیست خطاها...">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>کد خطا</th>
                <th>نام خطا</th>
                <th>گروه</th>
                <th>توضیحات</th>
                <th>استان</th>
                <th>شهرستان</th>
                <th>تاریخ ایجاد</th>
                <th>ضمیمه‌ها</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="errorTableBody">
            <?php foreach ($errors as $error): ?>
                <tr>
                    <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                    <td><?php echo htmlspecialchars($error['error_name']); ?></td>
                    <td><?php echo htmlspecialchars($error['group_name']); ?></td>
                    <td><?php echo htmlspecialchars($error['description']); ?></td>
                    <td><?php echo htmlspecialchars($error['province']); ?></td>
                    <td><?php echo htmlspecialchars($error['city']); ?></td>
                    <td><?php echo htmlspecialchars($error['created_at']); ?></td>
                    <td>
                        <?php if ($error['attachment']): ?>
                            <a href="/loco/assets/images/<?php echo htmlspecialchars($error['attachment']); ?>" target="_blank">دانلود</a>
                        <?php else: ?>
                            بدون ضمیمه
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/loco/pages/edit_error.php?id=<?php echo $error['id']; ?>" class="btn btn-warning">ویرایش</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>