<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "رمز عبور جدید و تکرار آن مطابقت ندارند.";
    } else {
        // بررسی صحت رمز عبور فعلی
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        $user = $stmt->fetch();

        if ($user && password_verify($current_password, $user['password'])) {
            // بروزرسانی رمز عبور
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmt->execute([
                'password' => $hashed_password,
                'user_id' => $_SESSION['user_id']
            ]);

            $success_message = "رمز عبور شما با موفقیت تغییر یافت.";
        } else {
            $error_message = "رمز عبور فعلی اشتباه است.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تغییر رمز عبور</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">تغییر رمز عبور</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="current_password">رمز عبور فعلی:</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">رمز عبور جدید:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">تکرار رمز عبور جدید:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">تغییر رمز عبور</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>