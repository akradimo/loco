<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /loco/pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $national_code = $_POST['national_code'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET fullname = :fullname, national_code = :national_code, username = :username, password = :password WHERE id = :id");
        $stmt->execute([
            'fullname' => $fullname,
            'national_code' => $national_code,
            'username' => $username,
            'password' => $hashedPassword,
            'id' => $_SESSION['user_id']
        ]);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fullname = :fullname, national_code = :national_code, username = :username WHERE id = :id");
        $stmt->execute([
            'fullname' => $fullname,
            'national_code' => $national_code,
            'username' => $username,
            'id' => $_SESSION['user_id']
        ]);
    }

    $_SESSION['username'] = $username;
    header("Location: /loco/pages/profile.php?success=1");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>پروفایل کاربری</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h2>پروفایل کاربری</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">تغییرات با موفقیت ذخیره شد.</div>
        <?php endif; ?>
        <form action="/loco/pages/profile.php" method="post">
            <div class="form-group">
                <label for="fullname">نام و نام خانوادگی:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="national_code">کد ملی:</label>
                <input type="text" class="form-control" id="national_code" name="national_code" value="<?php echo htmlspecialchars($user['national_code']); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور جدید:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>