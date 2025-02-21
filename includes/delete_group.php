<?php
include '../includes/auth.php';
include '../includes/db.php';

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