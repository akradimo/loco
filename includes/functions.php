<?php
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit();
    }
}

if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return $_SESSION['is_admin'] ?? false;
    }
}
?>
<?php
if (!function_exists('logActivity')) {
    function logActivity($user_id, $activity_type, $activity_details = null, $old_value = null, $new_value = null) {
        global $conn; // اتصال به دیتابیس

        $stmt = $conn->prepare("INSERT INTO activity_log (user_id, activity_type, activity_details, old_value, new_value) 
                                VALUES (:user_id, :activity_type, :activity_details, :old_value, :new_value)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':activity_type', $activity_type);
        $stmt->bindParam(':activity_details', $activity_details);
        $stmt->bindParam(':old_value', $old_value);
        $stmt->bindParam(':new_value', $new_value);
        $stmt->execute();
    }
}

if (!function_exists('sendEmailToAdmin')) {
    function sendEmailToAdmin($message) {
        $adminEmail = 'admin@example.com'; // ایمیل مدیر
        $subject = 'دسترسی غیرمجاز به بخش مدیریت';
        $headers = 'From: no-reply@loco.com' . "\r\n" .
                   'Reply-To: no-reply@loco.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($adminEmail, $subject, $message, $headers);
    }
}
?>