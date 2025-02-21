<?php
include '../includes/auth.php';

if (!$_SESSION['can_view_errors']) {
    header("Location: /loco/pages/access_denied.php");
    exit();
}

include '../includes/db.php';

// دریافت لیست گروه‌ها
$stmt = $conn->prepare("SELECT * FROM error_groups");
$stmt->execute();
$groups = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست گروه‌ها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لیست گروه‌ها</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>نام گروه</th>
                        <th>گروه والد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($group['group_name']); ?></td>
                            <td>
                                <?php if ($group['parent_group_id']): ?>
                                    <?php
                                    $stmt = $conn->prepare("SELECT group_name FROM error_groups WHERE id = :id");
                                    $stmt->execute(['id' => $group['parent_group_id']]);
                                    $parent_group = $stmt->fetch();
                                    echo htmlspecialchars($parent_group['group_name']);
                                    ?>
                                <?php else: ?>
                                    بدون گروه والد
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/loco/pages/edit_group.php?id=<?php echo $group['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>