<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userData && !empty($userData['name'])) {
    $userName = htmlspecialchars($userData['name']);
} else {
    $userName = 'Гость';
}