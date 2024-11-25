<?php
session_start();
include './conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status_order = $_POST['status_order'];
    $user_id = $_POST['user_id']; 

    $allowedStatuses = ["Оформлен", "Доставлен", "Оплачен", "В процессе доставки"];
    if (!in_array($status_order, $allowedStatuses)) {
        echo "Недопустимый статус заказа";
        exit;
    }

    $stmt = $pdo->prepare("UPDATE orders SET status_order = :status_order WHERE id = :order_id");
    $stmt->execute(['status_order' => $status_order, 'order_id' => $order_id]);

    header("Location: ../profile.php?user_id=" . $user_id);
    exit;
}