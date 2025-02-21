<?php
function redirect($url) {
    header("Location: $url");
    exit();
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function is_approved() {
    return isset($_SESSION['is_approved']) && $_SESSION['is_approved'];
}

function get_user_info($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    return $stmt->fetch();
}

function validateNationalCode($nationalCode) {
    if (strlen($nationalCode) != 10 || !is_numeric($nationalCode)) {
        return false;
    }

    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += (int)$nationalCode[$i] * (10 - $i);
    }

    $remainder = $sum % 11;
    $controlDigit = (int)$nationalCode[9];

    if (($remainder < 2 && $controlDigit == $remainder) || ($remainder >= 2 && $controlDigit == (11 - $remainder))) {
        return true;
    }

    return false;
}
?>