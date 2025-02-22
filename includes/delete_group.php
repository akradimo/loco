<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

checkAuth();
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_code = sanitizeInput($_POST['error_code']);
    $error_name = sanitizeInput($_POST['error_name']);
    $group_id = sanitizeInput($_POST['group_id']);
    $description = sanitizeInput($_POST['description']);
    $province = sanitizeInput($_POST['province']);
    $city = sanitizeInput($_POST['city']);
    $station = sanitizeInput($_POST['station']);
    $created_by = $_SESSION['user_id'];

    // بررسی تکراری بودن کد خطا
    $stmt = $conn->prepare("SELECT id FROM errors WHERE LOWER(error_code) = LOWER(:error_code)");
    $stmt->bindParam(':error_code', $error_code);
    $stmt->execute();
    $existingError = $stmt->fetch();

    if ($existingError) {
        $error = "این کد خطا موجود است. لطفاً کد دیگری وارد کنید.";
    } else {
        // اضافه کردن خطای جدید
        $stmt = $conn->prepare("INSERT INTO errors (error_code, error_name, group_id, description, province, city, station, created_by) 
                                VALUES (:error_code, :error_name, :group_id, :description, :province, :city, :station, :created_by)");
        $stmt->bindParam(':error_code', $error_code);
        $stmt->bindParam(':error_name', $error_name);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':station', $station);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->execute();

        // ثبت فعالیت در لاگ
        logActivity($_SESSION['user_id'], 'افزودن خطا', "کد خطا: $error_code, نام خطا: $error_name");

        redirect('/loco/pages/list_errors.php');
    }
}
checkAuth();
$conn = getDbConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM error_groups WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: /loco/pages/list_groups.php");
exit();
?>