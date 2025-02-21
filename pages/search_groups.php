<?php
include '../includes/db.php';

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("SELECT * FROM error_groups WHERE group_name LIKE :search");
$stmt->execute(['search' => "%$search%"]);
$groups = $stmt->fetchAll();

foreach ($groups as $group) {
    echo '<div class="group-item" data-id="' . $group['id'] . '">' . htmlspecialchars($group['group_name']) . '</div>';
}
?>