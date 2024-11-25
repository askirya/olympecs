<?php
session_start();
include './public/conn.php';
include './public/user.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./index.php");
    exit;
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$stmt = $pdo->prepare("SELECT email FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Пользователь не найден";
    exit;
}

$stmt = $pdo->prepare("SELECT id, order_number, final_total, status_order FROM orders WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="./assets/style/main.css"> <!-- Подключите CSS для стилей -->
</head>

<body class="body">
    <header class="header">
        <nav class="header__navigation">
            <div class="left-nav">
                <a href="./admin.php" class="logo-link">
                    <img src="./assets/img/logo.svg" alt="Логотип" class="logo">
                </a>
                <form id="search-form" class="search-form">
                    <input type="text" class="search__input" name="query" id="search-query"
                        placeholder="Введите название или артикул"
                        value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit" class="search__btn"><img src="./assets/img/search.svg"
                            alt="search__icon"></button>
                    <div id="search-results"></div>

                </form>
            </div>
            <ul class="menu__list-two">
                <li class="menu__list_item ">
                    <a href="./account.php" class="menu__list_link menu__list_link-two">
                        <img src="./assets/img/lk.svg" alt="" class="user-icon">
                        <span class="user-name"><?php echo $userName; ?></span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <section class="profile">
        <div class="container">
            
            <h3 class="title__third title__admin">Профиль: <?php echo htmlspecialchars($user['email']); ?></h3>
            <div class="flex-con">
                <nav class="account__navigation">
                    <a href="./admin.php" class="account__navigation_link">
                        <img src="./assets/img/profile-not.png" alt="Профиль" class="profile-icon__cart profile-icon">
                        <span class="account__navigation_item active-1">Пользователи</span>
                    </a>
                    <a href="./admin.php" class="account__navigation_link">
                        <img src="./assets/img/order-not.png" alt="Заказы" class="profile-icon">
                        <span class="account__navigation_item">Наличие товаров</span>
                    </a>
                    <div class="exit">
                        <a href="./public/logout.php" class="exit__btn">
                            <img src="./assets/img/exit.png" alt="Выход" class="exit__icon">
                            Выйти
                        </a>
                    </div>
                </nav>
                <div class="order-list__table">
                    
                    <table class="order-table">
                        <thead>
                            <tr class="table-header">
                                <th class="table-cell">Номер заказа</th>
                                <th class="table-cell">Сумма</th>
                                <th class="table-cell">Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr class="table-row">
                                    <td class="table-cell">Заказ
                                        #<?php echo htmlspecialchars($order['order_number']); ?></td>
                                    <td class="table-cell">
                                        <form action="./public/update_order.php" method="POST" class="edit-form">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="text" name="final_total"
                                                value="<?php echo number_format($order['final_total'], 0, ',', ' '); ?> Р"
                                                class="edit-price">
                                            <button type="submit" class="edit-button">✏️</button>
                                        </form>
                                    </td>
                                    <td class="table-cell">
                                        <form action="./public/update_order_status.php" method="POST"
                                            class="status-form">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <select name="status_order" onchange="this.form.submit()"
                                                class="status-select">
                                                <option value="Оформлен" <?php echo $order['status_order'] === 'Оформлен' ? 'selected' : ''; ?>>Оформлен</option>
                                                <option value="Доставлен" <?php echo $order['status_order'] === 'Доставлен' ? 'selected' : ''; ?>>Доставлен
                                                </option>
                                                <option value="Оплачен" <?php echo $order['status_order'] === 'Оплачен' ? 'selected' : ''; ?>>Оплачен</option>
                                                <option value="В процессе доставки" <?php echo $order['status_order'] === 'В процессе доставки' ? 'selected' : ''; ?>>В процессе доставки</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
        
                </div>  
            </div>
        </div>
    </section>
</body>

</html>