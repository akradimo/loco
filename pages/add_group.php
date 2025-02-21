<?php
include '../includes/auth.php';

if (!$_SESSION['can_add_group']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];

    if (empty($group_name)) {
        $error_message = "لطفاً نام گروه را وارد کنید.";
    } else {
        $stmt = $conn->prepare("INSERT INTO error_groups (group_name) VALUES (:group_name)");
        $stmt->execute(['group_name' => $group_name]);

        header("Location: /loco/pages/list_groups.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن گروه</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">افزودن گروه</h2>
        <form method="post">
            <div class="form-group">
                <label for="group_name">نام گروه:</label>
                <input type="text" class="form-control" id="group_name" name="group_name" required>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>