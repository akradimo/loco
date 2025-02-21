<?php
include '../includes/auth.php';
include '../includes/db.php';

checkAuth();
$conn = getDbConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM errors WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

redirect('/loco/pages/list_errors.php');
?>