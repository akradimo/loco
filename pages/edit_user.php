<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $personal_code = $_POST['personal_code'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET username = :username, fullname = :fullname, personal_code = :personal_code, is_admin = :is_admin WHERE id = :id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':personal_code', $personal_code);
    $stmt->bindParam(':is_admin', $is_admin);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /loco/pages/list_users.php");
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
        <form method="POST">
            <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">نام کامل</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="personal_code">کد پرسنلی</label>
                <input type="text" class="form-control" id="personal_code" name="personal_code" value="<?php echo htmlspecialchars($user['personal_code']); ?>">
            </div>
            <div class="form-group">
                <label for="is_admin">مدیر سیستم</label>
                <input type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>