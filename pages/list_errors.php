<?php
include '../includes/auth.php';
include '../includes/db.php';

// دریافت پارامترهای جستجو و مرتب‌سازی
$search_code = $_GET['search_code'] ?? '';
$search_name = $_GET['search_name'] ?? '';
$search_group = $_GET['search_group'] ?? '';
$order_by = $_GET['order_by'] ?? 'created_at';
$order_dir = $_GET['order_dir'] ?? 'DESC';

// اعتبارسنجی ستون‌های مرتب‌سازی
$valid_columns = ['error_code', 'error_name', 'created_at'];
if (!in_array($order_by, $valid_columns)) {
    $order_by = 'created_at';
}

// ساخت کوئری جستجو و مرتب‌سازی
$sql = "SELECT errors.*, users.fullname 
        FROM errors 
        LEFT JOIN users ON errors.created_by = users.id 
        WHERE 1=1";

if (!empty($search_code)) {
    $sql .= " AND errors.error_code LIKE :search_code";
}
if (!empty($search_name)) {
    $sql .= " AND errors.error_name LIKE :search_name";
}
if (!empty($search_group)) {
    $sql .= " AND errors.group_id = :search_group";
}

$sql .= " ORDER BY $order_by $order_dir";

$stmt = $conn->prepare($sql);

if (!empty($search_code)) {
    $stmt->bindValue(':search_code', "%$search_code%");
}
if (!empty($search_name)) {
    $stmt->bindValue(':search_name', "%$search_name%");
}
if (!empty($search_group)) {
    $stmt->bindValue(':search_group', $search_group);
}

$stmt->execute();
$errors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست خطاها</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">لیست خطاها</h2>
        <form method="get" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search_code" class="form-control" placeholder="جستجو بر اساس کد خطا" value="<?php echo htmlspecialchars($search_code); ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search_name" class="form-control" placeholder="جستجو بر اساس نام خطا" value="<?php echo htmlspecialchars($search_name); ?>">
                </div>
                <div class="col-md-3">
                    <select name="search_group" class="form-control">
                        <option value="">انتخاب گروه</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM error_groups");
                        $stmt->execute();
                        $groups = $stmt->fetchAll();
                        foreach ($groups as $group): ?>
                            <option value="<?php echo $group['id']; ?>" <?php echo $search_group == $group['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($group['group_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </div>
            </div>
        </form>
        <table id="errorsTable" class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?order_by=error_code&order_dir=<?php echo $order_by == 'error_code' && $order_dir == 'ASC' ? 'DESC' : 'ASC'; ?>">کد خطا</a></th>
                    <th><a href="?order_by=error_name&order_dir=<?php echo $order_by == 'error_name' && $order_dir == 'ASC' ? 'DESC' : 'ASC'; ?>">نام خطا</a></th>
                    <th>گروه</th>
                    <th>توضیحات</th>
                    <th>استان</th>
                    <th>شهر</th>
                    <th>ایستگاه</th>
                    <th><a href="?order_by=created_at&order_dir=<?php echo $order_by == 'created_at' && $order_dir == 'ASC' ? 'DESC' : 'ASC'; ?>">تاریخ ایجاد</a></th>
                    <th>عملیات</th>
                    <?php if ($_SESSION['is_admin']): ?>
                        <th>تغییرات</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($errors as $error): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                        <td><?php echo htmlspecialchars($error['error_name']); ?></td>
                        <td><?php echo htmlspecialchars($error['group_id']); ?></td>
                        <td><?php echo htmlspecialchars($error['description']); ?></td>
                        <td><?php echo htmlspecialchars($error['province']); ?></td>
                        <td><?php echo htmlspecialchars($error['city']); ?></td>
                        <td><?php echo htmlspecialchars($error['station']); ?></td>
                        <td><?php echo htmlspecialchars($error['created_at']); ?></td>
                        <td>
                            <a href="/loco/pages/edit_error.php?id=<?php echo $error['id']; ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="/loco/includes/delete_error.php?id=<?php echo $error['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                        </td>
                        <?php if ($_SESSION['is_admin']): ?>
                            <td>
                                <a href="/loco/pages/error_history.php?id=<?php echo $error['id']; ?>" class="btn btn-info btn-sm">تغییرات</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="/loco/assets/js/jquery.min.js"></script>
    <script src="/loco/assets/js/jquery.dataTables.min.js"></script>
    <script src="/loco/assets/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#errorsTable').DataTable({
                "language": {
                    "url": "/loco/assets/json/persian.json"
                }
            });
        });
    </script>
</body>
</html>