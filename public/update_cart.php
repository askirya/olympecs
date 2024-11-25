<?php
session_start();

$productId = $_POST['product_id'] ?? 0;
$action = $_POST['action'] ?? '';

if ($productId && isset($_SESSION['cart'][$productId])) {
    if ($action === 'increase') {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] > 1) {
        $_SESSION['cart'][$productId]['quantity'] -= 1;
    }

    echo json_encode(['status' => 'success', 'message' => 'Количество обновлено']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный товар']);
}
?>