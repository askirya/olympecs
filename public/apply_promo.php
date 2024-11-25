<?php
session_start();

$promoCode = $_POST['promo_code'] ?? '';

if ($promoCode === 'DISCOUNT500') { 
    $_SESSION['promo_code'] = $promoCode;
    echo json_encode(['status' => 'success', 'message' => 'Промокод применен']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный промокод']);
}
?>