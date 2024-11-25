<?php
include './conn.php';
include './session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, role, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_get_info($user['password'])['algo'] !== 0) {
            $isPasswordCorrect = password_verify($password, $user['password']);
        } else {
            $isPasswordCorrect = $password === $user['password'];

            if ($isPasswordCorrect) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = :hashedPassword WHERE id = :id");
                $updateStmt->execute(['hashedPassword' => $hashedPassword, 'id' => $user['id']]);
            }
        }

        if ($isPasswordCorrect) {
            loginUser($user['id'], $user['role']);
            header("Location: ../account.php");
            exit;
        } else {
            echo "Неверный пароль";
        }
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $name = $_POST['name'] ?? ''; 

        $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
        $insertStmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        $userId = $pdo->lastInsertId();
        loginUser($userId, 'user');
        header("Location: ../account.php");
        exit;
    }
}
?>