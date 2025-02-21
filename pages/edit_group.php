<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM error_groups WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $group = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];

    $stmt = $conn->prepare("UPDATE error_groups SET group_name = :group_name WHERE id = :id");
    $stmt->bindParam(':group_name', $group_name);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: /loco/pages/list_groups.php");
    exit();
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
        <form method="POST">
            <div class="form-group">
                <label for="group_name">نام گروه</label>
                <input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo htmlspecialchars($group['group_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>