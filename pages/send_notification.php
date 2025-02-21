<?php
include '../includes/auth.php';

// فقط مدیران می‌توانند به این صفحه دسترسی داشته باشند
if (!$_SESSION['is_admin']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message) VALUES (:user_id, :title, :message)");
    $stmt->execute([
        'user_id' => $user_id,
        'title' => $title,
        'message' => $message
    ]);

    $success_message = "اطلاعیه با موفقیت ارسال شد.";
}

// دریافت لیست کاربران
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ارسال اطلاعیه</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ارسال اطلاعیه</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
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
            <div class="form-group">
                <label for="title">عنوان:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="message">پیام:</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">ارسال</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>