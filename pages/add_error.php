<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

// بررسی نقش کاربر (فقط کاربران مجاز می‌توانند خطا اضافه کنند)
if (!$_SESSION['is_admin'] && !$_SESSION['can_add_error']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_code = sanitizeInput($_POST['error_code']);
    $error_name = sanitizeInput($_POST['error_name']);
    $group_id = sanitizeInput($_POST['group_id']);
    $description = sanitizeInput($_POST['description']);
    $province = sanitizeInput($_POST['province']);
    $city = sanitizeInput($_POST['city']);
    $station = sanitizeInput($_POST['station']);
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO errors (error_code, error_name, group_id, description, province, city, station, created_by) 
                            VALUES (:error_code, :error_name, :group_id, :description, :province, :city, :station, :created_by)");
    $stmt->bindParam(':error_code', $error_code);
    $stmt->bindParam(':error_name', $error_name);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':province', $province);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':station', $station);
    $stmt->bindParam(':created_by', $created_by);
    $stmt->execute();

    redirect('/loco/pages/list_errors.php');
}

// دریافت لیست گروه‌ها
$stmt = $conn->prepare("SELECT * FROM error_groups");
$stmt->execute();
$groups = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن خطا</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">افزودن خطا</h2>
        <form method="POST">
            <div class="form-group">
                <label for="error_code">کد خطا</label>
                <input type="text" class="form-control" id="error_code" name="error_code" required>
            </div>
            <div class="form-group">
                <label for="error_name">نام خطا</label>
                <input type="text" class="form-control" id="error_name" name="error_name" required>
            </div>
            <div class="form-group">
                <label for="group_id">گروه</label>
                <select class="form-control" id="group_id" name="group_id" required>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="province">استان</label>
                <input type="text" class="form-control" id="province" name="province" required>
            </div>
            <div class="form-group">
                <label for="city">شهر</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="station">ایستگاه</label>
                <input type="text" class="form-control" id="station" name="station" required>
            </div>
            <button type="submit" class="btn btn-primary">افزودن خطا</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>