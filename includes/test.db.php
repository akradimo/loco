<?php
include __DIR__ . '/includes/db.php'; // مسیر صحیح به فایل db.php

try {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll();
    echo "<pre>";
    print_r($users);
    echo "</pre>";
} catch (PDOException $e) {
    echo "خطا: " . $e->getMessage();
}
?>