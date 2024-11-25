<?php
session_start();
include './conn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Пользователь не авторизован. Пожалуйста, войдите в систему.']);
    exit;
}

$cartItems = $_SESSION['cart'] ?? [];
$totalItems = 0;
$totalPrice = 0;
$discount = 0;
$promoDiscount = 0;

$promoCode = $_SESSION['promo_code'] ?? null;
if ($promoCode === 'DISCOUNT500') {
    $promoDiscount = 500;
}

$user_id = $_SESSION['user_id'];

foreach ($cartItems as $productId => $item) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $quantity = $item['quantity'];
    $itemTotalPrice = $product['discounted_price'] * $quantity;
    $totalPrice += $itemTotalPrice;

    $itemDiscount = ($product['original_price'] - $product['discounted_price']) * $quantity;
    $discount += $itemDiscount;
}

$finalTotal = $totalPrice - $discount - $promoDiscount;

$orderNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

try {
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_number, total_items, total_price, discount, promo_code, final_total, status_order, payment_status, created_at)
                           VALUES (:user_id, :order_number, :total_items, :total_price, :discount, :promo_code, :final_total, 'Новый', 'Не оплачен', NOW())");
    $stmt->execute([
        'user_id' => $user_id,
        'order_number' => $orderNumber,
        'total_items' => count($cartItems),
        'total_price' => $totalPrice,
        'discount' => $discount,
        'promo_code' => $promoCode,
        'final_total' => $finalTotal
    ]);

    unset($_SESSION['cart']);
    unset($_SESSION['promo_code']);

    echo json_encode(['status' => 'success', 'message' => 'Заказ успешно оформлен!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении заказа: ' . $e->getMessage()]);
}
?>