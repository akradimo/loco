<?php
include '../includes/auth.php';

if (!$_SESSION['can_edit_group']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

$group_id = $_GET['id'] ?? null;
if (!$group_id) {
    header("Location: /loco/pages/list_groups.php");
    exit();
}

// دریافت اطلاعات گروه برای ویرایش
$stmt = $conn->prepare("SELECT * FROM error_groups WHERE id = :group_id");
$stmt->execute(['group_id' => $group_id]);
$group = $stmt->fetch();

if (!$group) {
    header("Location: /loco/pages/list_groups.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];

    if (empty($group_name)) {
        $error_message = "لطفاً نام گروه را وارد کنید.";
    } else {
        $stmt = $conn->prepare("UPDATE error_groups SET group_name = :group_name WHERE id = :group_id");
        $stmt->execute([
            'group_name' => $group_name,
            'group_id' => $group_id
        ]);

        header("Location: /loco/pages/list_groups.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش گروه</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">ویرایش گروه</h2>
        <form method="post">
            <div class="form-group">
                <label for="group_name">نام گروه:</label>
                <input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo htmlspecialchars($group['group_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>