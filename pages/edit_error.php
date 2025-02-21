<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM errors WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $error = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_code = $_POST['error_code'];
    $error_name = $_POST['error_name'];
    $group_id = $_POST['group_id'];
    $description = $_POST['description'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $station = $_POST['station'];

    $stmt = $conn->prepare("UPDATE errors SET error_code = :error_code, error_name = :error_name, group_id = :group_id, description = :description, province = :province, city = :city, station = :station WHERE id = :id");
    $stmt->bindParam(':error_code', $error_code);
    $stmt->bindParam(':error_name', $error_name);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':province', $province);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':station', $station);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /loco/pages/list_errors.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش خطا</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ویرایش خطا</h2>
        <form method="POST">
            <div class="form-group">
                <label for="error_code">کد خطا</label>
                <input type="text" class="form-control" id="error_code" name="error_code" value="<?php echo htmlspecialchars($error['error_code']); ?>" required>
            </div>
            <div class="form-group">
                <label for="error_name">نام خطا</label>
                <input type="text" class="form-control" id="error_name" name="error_name" value="<?php echo htmlspecialchars($error['error_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="group_id">گروه</label>
                <select class="form-control" id="group_id" name="group_id" required>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM error_groups");
                    $stmt->execute();
                    $groups = $stmt->fetchAll();
                    foreach ($groups as $group) {
                        $selected = $group['id'] == $error['group_id'] ? 'selected' : '';
                        echo "<option value='{$group['id']}' $selected>{$group['group_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($error['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="province">استان</label>
                <input type="text" class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($error['province']); ?>" required>
            </div>
            <div class="form-group">
                <label for="city">شهر</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($error['city']); ?>" required>
            </div>
            <div class="form-group">
                <label for="station">ایستگاه</label>
                <input type="text" class="form-control" id="station" name="station" value="<?php echo htmlspecialchars($error['station']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>