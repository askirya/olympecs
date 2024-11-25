<?php
require_once 'session.php';

if (!isUserLoggedIn()) {
    header('Location: ../account.php');
    exit();
}

if (!isUserRole('admin')) {
    header('Location: ../admin.php');
    exit();
}
?>