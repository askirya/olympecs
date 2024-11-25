<?php
session_start();

$productId = $_POST['product_id'] ?? 0;

if ($productId && isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
    echo json_encode(['status' => 'success', 'message' => 'Товар удален из корзины']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный товар']);
}
?>