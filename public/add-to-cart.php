<?php
session_start();

$productId = $_POST['product_id'] ?? 0;

if ($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$productId] = [
            'product_id' => $productId,
            'quantity' => 1
        ];
    }

    echo json_encode(['status' => 'success', 'message' => 'Товар добавлен в корзину']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный товар']);
}
?>