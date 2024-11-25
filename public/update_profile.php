<?php
session_start();
include './conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowedFields = ['name', 'last_name', 'surname', 'phone', 'email'];
    $updateData = [];

    foreach ($allowedFields as $field) {
        if (isset($_POST[$field])) {
            $updateData[$field] = $_POST[$field];
        }
    }

    if (!empty($updateData)) {
        $setClause = implode(", ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($updateData)));
        $updateData['user_id'] = $user_id;

        $stmt = $pdo->prepare("UPDATE users SET $setClause WHERE id = :user_id");
        $stmt->execute($updateData);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Нет данных для обновления']);
    }
}
?>