<?php
session_start();
include './conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $final_total = floatval(str_replace(' ', '', $_POST['final_total']));
    $user_id = $_POST['user_id']; 

    $stmt = $pdo->prepare("UPDATE orders SET final_total = :final_total WHERE id = :order_id");
    $stmt->execute(['final_total' => $final_total, 'order_id' => $order_id]);

    header("Location: ../profile.php?user_id=" . $user_id);
    exit;
}