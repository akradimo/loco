<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

checkAuth();

// بررسی نقش کاربر (فقط ادمین می‌تواند گروه اضافه کند)
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = sanitizeInput($_POST['group_name']);

    // بررسی تکراری بودن گروه
    $stmt = $conn->prepare("SELECT id FROM error_groups WHERE group_name = :group_name");
    $stmt->bindParam(':group_name', $group_name);
    $stmt->execute();
    $existingGroup = $stmt->fetch();

    if ($existingGroup) {
        $error = "این گروه موجود است. لطفاً اگر مشکلی وجود دارد با مدیر تماس بگیرید.";
    } else {
        // اضافه کردن گروه جدید
        $stmt = $conn->prepare("INSERT INTO error_groups (group_name) VALUES (:group_name)");
        $stmt->bindParam(':group_name', $group_name);
        $stmt->execute();

        redirect('/loco/pages/list_groups.php');
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن گروه</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">افزودن گروه</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="group_name">نام گروه</label>
                <input type="text" class="form-control" id="group_name" name="group_name" required>
            </div>
            <button type="submit" class="btn btn-primary">افزودن گروه</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>