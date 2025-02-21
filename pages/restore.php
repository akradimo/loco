<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $backup_file = $_FILES['backup_file']['tmp_name'];

    if ($backup_file) {
        $command = "mysql --user={$username} --password={$password} --host={$host} {$dbname} < {$backup_file}";
        exec($command);

        $success_message = "پشتیبان با موفقیت بازگردانی شد.";
    } else {
        $error_message = "لطفاً یک فایل پشتیبان انتخاب کنید.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بازگردانی پشتیبان</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">بازگردانی پشتیبان</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="backup_file">فایل پشتیبان:</label>
                <input type="file" class="form-control-file" id="backup_file" name="backup_file" required>
            </div>
            <button type="submit" class="btn btn-primary">بازگردانی</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>