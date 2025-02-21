<?php
include '../includes/auth.php';

if (!$_SESSION['can_edit_error']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

$error_id = $_GET['id'] ?? null;
if (!$error_id) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت اطلاعات خطا برای ویرایش
$stmt = $conn->prepare("SELECT * FROM errors WHERE id = :error_id");
$stmt->execute(['error_id' => $error_id]);
$error = $stmt->fetch();

if (!$error) {
    header("Location: /loco/pages/list_errors.php");
    exit();
}

// دریافت لیست گروه‌ها
$stmt = $conn->prepare("SELECT * FROM error_groups");
$stmt->execute();
$groups = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_code = $_POST['error_code'];
    $error_name = $_POST['error_name'];
    $group_id = $_POST['group_id'];
    $subgroup_id = $_POST['subgroup_id'] ?? null;
    $description = $_POST['description'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $station = $_POST['station'];
    $attachment = $error['attachment'];

    // آپلود فایل پیوست
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $attachment = basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], $upload_dir . $attachment);
    }

    // ویرایش خطا در دیتابیس
    $stmt = $conn->prepare("UPDATE errors SET error_code = :error_code, error_name = :error_name, group_id = :group_id, subgroup_id = :subgroup_id, description = :description, province = :province, city = :city, station = :station, attachment = :attachment WHERE id = :error_id");
    $stmt->execute([
        'error_code' => $error_code,
        'error_name' => $error_name,
        'group_id' => $group_id,
        'subgroup_id' => $subgroup_id,
        'description' => $description,
        'province' => $province,
        'city' => $city,
        'station' => $station,
        'attachment' => $attachment,
        'error_id' => $error_id
    ]);

    // ثبت تاریخچه تغییرات
    $stmt = $conn->prepare("
        INSERT INTO error_history (error_id, user_id, change_type, change_details) 
        VALUES (:error_id, :user_id, 'ویرایش', 'جزئیات خطا ویرایش شد')
    ");
    $stmt->execute([
        'error_id' => $error_id,
        'user_id' => $_SESSION['user_id']
    ]);

    header("Location: /loco/pages/list_errors.php?success=1");
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
        <form action="/loco/pages/edit_error.php?id=<?php echo $error_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="error_code">کد خطا:</label>
                <input type="text" class="form-control" id="error_code" name="error_code" value="<?php echo htmlspecialchars($error['error_code']); ?>" required>
            </div>
            <div class="form-group">
                <label for="error_name">نام خطا:</label>
                <input type="text" class="form-control" id="error_name" name="error_name" value="<?php echo htmlspecialchars($error['error_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="group_id">گروه:</label>
                <select class="form-control" id="group_id" name="group_id" required>
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?php echo $group['id']; ?>" <?php echo $group['id'] === $error['group_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($group['group_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">توضیحات:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($error['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="province">استان:</label>
                <input type="text" class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($error['province']); ?>">
            </div>
            <div class="form-group">
                <label for="city">شهر:</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($error['city']); ?>">
            </div>
            <div class="form-group">
                <label for="station">ایستگاه:</label>
                <input type="text" class="form-control" id="station" name="station" value="<?php echo htmlspecialchars($error['station']); ?>">
            </div>
            <div class="form-group">
                <label for="attachment">فایل پیوست:</label>
                <input type="file" class="form-control-file" id="attachment" name="attachment">
                <?php if ($error['attachment']): ?>
                    <p>فایل فعلی: <a href="/loco/uploads/<?php echo htmlspecialchars($error['attachment']); ?>" target="_blank">دانلود</a></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>