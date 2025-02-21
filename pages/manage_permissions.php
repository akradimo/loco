<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

// دریافت لیست کاربران
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

// بروزرسانی دسترسی‌ها
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $can_edit_error = isset($_POST['can_edit_error']) ? 1 : 0;
    $can_delete_error = isset($_POST['can_delete_error']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET can_edit_error = :can_edit_error, can_delete_error = :can_delete_error WHERE id = :user_id");
    $stmt->execute([
        'can_edit_error' => $can_edit_error,
        'can_delete_error' => $can_delete_error,
        'user_id' => $user_id
    ]);

    header("Location: /loco/pages/manage_permissions.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت دسترسی‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">مدیریت دسترسی‌ها</h2>
        <form method="post">
            <div class="form-group">
                <label for="user_id">کاربر:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['fullname']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="can_edit_error" name="can_edit_error">
                <label class="form-check-label" for="can_edit_error">اجازه ویرایش خطا</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="can_delete_error" name="can_delete_error">
                <label class="form-check-label" for="can_delete_error">اجازه حذف خطا</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>