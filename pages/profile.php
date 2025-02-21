<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $personal_code = $_POST['personal_code'];

    $stmt = $conn->prepare("UPDATE users SET fullname = :fullname, personal_code = :personal_code WHERE id = :user_id");
    $stmt->execute([
        'fullname' => $fullname,
        'personal_code' => $personal_code,
        'user_id' => $_SESSION['user_id']
    ]);

    $_SESSION['fullname'] = $fullname;
    $success_message = "پروفایل شما با موفقیت بروزرسانی شد.";
}

// دریافت اطلاعات کاربر
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پروفایل کاربر</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">پروفایل کاربر</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="fullname">نام کامل:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="personal_code">کد پرسنلی:</label>
                <input type="text" class="form-control" id="personal_code" name="personal_code" value="<?php echo htmlspecialchars($user['personal_code'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>