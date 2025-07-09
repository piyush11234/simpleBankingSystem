<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isManager() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'manager';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

function redirectIfNotManager() {
    redirectIfNotLoggedIn();
    if (!isManager()) {
        header("Location: ../user/dashboard.php");
        exit();
    }
}
?>