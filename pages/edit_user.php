<?php
include '../includes/auth.php';

if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    header("Location: /loco/pages/list_users.php");
    exit();
}

// دریافت اطلاعات کاربر برای ویرایش
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: /loco/pages/list_users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $personal_code = $_POST['personal_code'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET fullname = :fullname, personal_code = :personal_code, is_admin = :is_admin WHERE id = :user_id");
    $stmt->execute([
        'fullname' => $fullname,
        'personal_code' => $personal_code,
        'is_admin' => $is_admin,
        'user_id' => $user_id
    ]);

    header("Location: /loco/pages/list_users.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش کاربر</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ویرایش کاربر</h2>
        <form method="post">
            <div class="form-group">
                <label for="fullname">نام کامل:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="personal_code">کد پرسنلی:</label>
                <input type="text" class="form-control" id="personal_code" name="personal_code" value="<?php echo htmlspecialchars($user['personal_code']); ?>" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_admin">مدیر سیستم</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>