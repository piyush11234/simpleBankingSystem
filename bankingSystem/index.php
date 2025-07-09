<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: " . (isManager() ? 'manager/dashboard.php' : 'user/dashboard.php'));
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>