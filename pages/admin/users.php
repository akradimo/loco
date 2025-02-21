<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /loco/pages/login.php");
    exit();
}
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/db.php';
?>

<div class="container6">
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
            <?php
            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $users = $stmt->fetchAll();

            foreach ($users as $user) {
                echo "<tr>
                        <td>{$user['username']}</td>
                        <td>{$user['fullname']}</td>
                        <td>" . ($user['is_approved'] ? 'تایید شده' : 'تایید نشده') . "</td>
                        <td>
                            <form action='/loco/includes/admin.php?action=update_permissions&id={$user['id']}' method='post'>
                                <label>
                                    <input type='checkbox' name='can_add_error' " . ($user['can_add_error'] ? 'checked' : '') . "> افزودن خطا
                                </label>
                                <label>
                                    <input type='checkbox' name='can_edit_error' " . ($user['can_edit_error'] ? 'checked' : '') . "> ویرایش خطا
                                </label>
                                <label>
                                    <input type='checkbox' name='can_add_group' " . ($user['can_add_group'] ? 'checked' : '') . "> افزودن گروه
                                </label>
                                <label>
                                    <input type='checkbox' name='can_edit_group' " . ($user['can_edit_group'] ? 'checked' : '') . "> ویرایش گروه
                                </label>
                                <button type='submit' class='btn btn-primary'>ذخیره</button>
                            </form>
                        </td>
                        <td>
                            <a href='/loco/includes/admin.php?action=approve&id={$user['id']}'>" . ($user['is_approved'] ? 'لغو تایید' : 'تایید') . "</a> |
                            <a href='/loco/includes/admin.php?action=delete&id={$user['id']}'>حذف</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>