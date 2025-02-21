<?php
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['can_add_group']) || !$_SESSION['can_add_group']) {
    header("Location: /loco/pages/dashboard.php");
    exit();
}

// دریافت لیست گروه‌ها از دیتابیس
$stmt = $conn->prepare("SELECT * FROM error_groups");
$stmt->execute();
$groups = $stmt->fetchAll();
?>

<div class="container">
    <h2>لیست گروه‌ها</h2>
    <a href="/loco/pages/add_group.php" class="btn btn-primary mb-3">افزودن گروه</a>
    <input type="text" id="searchGroup" class="form-control mb-3" placeholder="جستجو در لیست گروه‌ها...">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>نام گروه</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="groupTableBody">
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?php echo htmlspecialchars($group['group_name']); ?></td>
                    <td>
                        <a href="/loco/pages/edit_group.php?id=<?php echo $group['id']; ?>" class="btn btn-warning">ویرایش</a>
                        <a href="/loco/includes/groups.php?action=delete&id=<?php echo $group['id']; ?>" class="btn btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>