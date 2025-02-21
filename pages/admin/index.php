<?php
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /loco/pages/login.php");
    exit();
}

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/db.php';

// دریافت لیست کاربران از دیتابیس
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="container7">
    <h2>مدیریت کاربران</h2>
    <table class="table">
        <thead>
            <tr>
                <th>نام کاربری</th>
                <th>نام کامل</th>
                <th>وضعیت تایید</th>
                <th>دسترسی‌ها</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                    <td><?php echo $user['is_approved'] ? 'تایید شده' : 'تایید نشده'; ?></td>
                    <td>
                        <form action="/loco/includes/admin.php?action=update_permissions&id=<?php echo $user['id']; ?>" method="post">
                            <label>
                                <input type="checkbox" name="can_add_error" <?php echo $user['can_add_error'] ? 'checked' : ''; ?>> افزودن خطا
                            </label>
                            <label>
                                <input type="checkbox" name="can_edit_error" <?php echo $user['can_edit_error'] ? 'checked' : ''; ?>> ویرایش خطا
                            </label>
                            <label>
                                <input type="checkbox" name="can_add_group" <?php echo $user['can_add_group'] ? 'checked' : ''; ?>> افزودن گروه
                            </label>
                            <label>
                                <input type="checkbox" name="can_edit_group" <?php echo $user['can_edit_group'] ? 'checked' : ''; ?>> ویرایش گروه
                            </label>
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </form>
                    </td>
                    <td>
                        <a href="/loco/includes/admin.php?action=approve&id=<?php echo $user['id']; ?>"><?php echo $user['is_approved'] ? 'لغو تایید' : 'تایید'; ?></a> |
                        <a href="/loco/includes/admin.php?action=delete&id=<?php echo $user['id']; ?>">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>