<?php
include '../includes/db.php';

function buildTree($parentId = null) {
    global $conn;
    $tree = '';
    $stmt = $conn->prepare("SELECT * FROM error_groups WHERE parent_group_id " . ($parentId ? "= :parentId" : "IS NULL"));
    if ($parentId) {
        $stmt->execute(['parentId' => $parentId]);
    } else {
        $stmt->execute();
    }
    $groups = $stmt->fetchAll();

    if ($groups) {
        $tree .= '<ul>';
        foreach ($groups as $group) {
            $tree .= '<li class="group-item" data-id="' . $group['id'] . '">' . htmlspecialchars($group['group_name']);
            $tree .= buildTree($group['id']);
            $tree .= '</li>';
        }
        $tree .= '</ul>';
    }

    return $tree;
}

echo buildTree();
?>