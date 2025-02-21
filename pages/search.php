<?php
include '../includes/auth.php';
include '../includes/db.php';

$search_query = $_GET['q'] ?? '';

if (!empty($search_query)) {
    $stmt = $conn->prepare("
        SELECT * FROM errors 
        WHERE error_code LIKE :search_query 
        OR error_name LIKE :search_query 
        OR description LIKE :search_query
    ");
    $stmt->execute(['search_query' => "%$search_query%"]);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جستجو</title>
    <link rel="stylesheet" href="/loco/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/loco/assets/css/custom.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">جستجو</h2>
        <form method="get" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="جستجو...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </div>
            </div>
        </form>
        <?php if (!empty($search_query)): ?>
            <h3 class="mb-4">نتایج جستجو برای "<?php echo htmlspecialchars($search_query); ?>"</h3>
            <?php if (count($results) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>کد خطا</th>
                            <th>نام خطا</th>
                            <th>توضیحات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['error_code']); ?></td>
                                <td><?php echo htmlspecialchars($result['error_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['description']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">هیچ نتیجه‌ای یافت نشد.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>