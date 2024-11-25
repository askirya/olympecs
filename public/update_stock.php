<?php
session_start();
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $stock = intval($_POST['stock']);

    if ($stock < 0) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Недопустимое количество']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE products SET stock = :stock WHERE id = :id");
        $stmt->execute(['stock' => $stock, 'id' => $product_id]);
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при обновлении количества']);
    }
}
?>