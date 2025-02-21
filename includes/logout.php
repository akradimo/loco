<?php
session_start();
session_destroy();
header("Location: /loco/pages/login.php");
exit();
?>