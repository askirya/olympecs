<?php
session_start();

function loginUser($userId, $role) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['role'] = $role;
    $_SESSION['logged_in'] = true;
}

function isUserLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function isUserRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function logoutUser() {
    session_unset();
    session_destroy();
}
?>