<?php
session_start();
include './public/conn.php';
include './public/user.php';
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, order_number, status_order, payment_status, total_price, created_at 
                       FROM orders 
                       WHERE user_id = :user_id 
                       ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="./assets/script/cart.js" defer></script>
    <script src="./assets/script/account.js" defer></script>
    <link rel="stylesheet" href="./assets/style/main.css" defer>
    <title>История заказов</title>

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
                            <button type="submit" class="search__btn"><img class="none" src="./assets/img/search.svg"
                                    alt="search__icon"></button>
                                <button type="button" class="search__close-btn" id="search-close-btn" aria-label="Закрыть поиск">
                                    &times; 
                                </button>
                            <div id="search-results"></div>
                        </form>
                    <!-- Кнопка открытия поиска для мобильных -->
                    <button type="button" class="search-toggle-btn" id="search-toggle-btn" aria-label="Открыть поиск" aria-expanded="false" aria-controls="search-form">
                        <img src="./assets/img/search.svg" alt="Поиск">
                    </button>
                </div>
                <ul class="menu__list-two">
                    <li class="menu__list_item">
                        <a href="./cart.php" class="menu__list_link">
                            <img class="cart__icon" src="./assets/img/cart-white.png" alt="Корзина">
                        </a>
                    </li>
                    <li class="menu__list_item ">
                        <a href="./account.php" class="menu__list_link menu__list_link-two">
                            <img src="./assets/img/lk.svg" alt="" class="user-icon">
                            <span class="user-name"><?php echo $userName; ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
    </header>
    <script src="./assets/script/burger-two.js"></script>
    <section class="orders-section">
        <div class="container">
            <div class="menu">
                <?php include './public/services_dropdown.php'; ?>
                <?php include './public/products_dropdown.php'; ?>
                <button class="catalog-button">Поиск по каталогу</button>
            </div>
            <h3 class="title__third title__order">История заказов</h3>

            <div class="orders-wrapper">
                <nav class="account__navigation">
                    <a href="./account.php" class="account__navigation_link">
                        <img src="./assets/img/profile-not.png" alt="Профиль" class="profile-icon">
                        <span class="account__navigation_item">Профиль</span>
                    </a>
                    <a href="./order.php" class="account__navigation_link">
                        <img src="./assets/img/order-not.png" alt="Заказы" class="profile-icon profile-icon__cart">
                        <span class="account__navigation_item active-1">Заказы</span>
                    </a>
                    <a href="./cart.php" class="account__navigation_link">
                        <img src="./assets/img/cart.png" alt="Корзина" class="profile-icon">
                        <span class="account__navigation_item">Корзина</span>
                    </a>
                    <div class="exit">
                        <a href="./public/logout.php" class="exit__btn">
                            <img src="./assets/img/exit.png" alt="Выход" class="exit__icon">
                            Выйти
                        </a>
                    </div>
                </nav>
                <div class="orders-history">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="order-item">
                                <div class="orders-one">
                                    <p class="order__account"><strong
                                            class="order__number">#<?php echo htmlspecialchars($order['id']); ?></strong> Счет -
                                        <?php echo htmlspecialchars($order['order_number']); ?>
                                    </p>
                                    <p class="order_p order__date">Заказ от
                                        <?php echo date("d.m.Y", strtotime($order['created_at'])); ?>
                                    </p>
                                </div>
                                <p class="order_p order__status">Статус заказа: <span
                                        class="status-order"><?php echo htmlspecialchars($order['status_order']); ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6 12.5C9.3138 12.5 12 9.8138 12 6.5C12 3.1862 9.3138 0.5 6 0.5C2.6862 0.5 0 3.1862 0 6.5C0 9.8138 2.6862 12.5 6 12.5ZM9.2226 4.601C9.25067 4.57208 9.27262 4.53781 9.28716 4.50022C9.30169 4.46263 9.3085 4.4225 9.30718 4.38222C9.30586 4.34195 9.29644 4.30235 9.27948 4.26579C9.26252 4.22923 9.23837 4.19647 9.20847 4.16945C9.17857 4.14243 9.14353 4.12172 9.10545 4.10854C9.06736 4.09536 9.02701 4.08999 8.98681 4.09275C8.9466 4.0955 8.90737 4.10633 8.87144 4.12459C8.83551 4.14285 8.80363 4.16815 8.7777 4.199L5.184 8.1701L3.207 6.2828C3.14947 6.22782 3.07246 6.19795 2.99291 6.19975C2.91336 6.20155 2.83778 6.23487 2.7828 6.2924C2.72782 6.34993 2.69795 6.42694 2.69975 6.50649C2.70155 6.58604 2.73487 6.66162 2.7924 6.7166L4.9926 8.8166L5.2155 9.0296L5.4222 8.801L9.2226 4.601Z"
                                                fill="#30C83C" />
                                        </svg>
                                    </span></p>
                                <p class="order__status order__status_payment order_p">Статус оплаты:
                                    <span
                                        class="payment-status <?php echo $order['payment_status'] === 'Оплачен' ? 'paid' : 'unpaid'; ?>">
                                        <?php if ($order['payment_status'] === 'Оплачен'): ?>
                                            <!-- Зеленая иконка для "Оплачен" -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                                fill="none">
                                                <circle cx="4.5" cy="4.5" r="4.5" fill="#15701C" />
                                            </svg>
                                        <?php else: ?>
                                            <!-- Красная иконка для "Не оплачен" -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                                fill="none">
                                                <circle cx="4.5" cy="4.5" r="4.5" fill="#FF0000" />
                                            </svg>
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($order['payment_status']); ?>
                                    </span>
                                </p>
                                <p class="order__p total__count">Полная сумма: <span
                                        class="total__count-span"><?php echo number_format($order['total_price'], 0, ',', ' '); ?>
                                        Р</span></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-orders empty-cart ">
                            <p class="empty-cart__text">Заказов нет</p>
                            <img class="empty-cart__icon-" src="./assets/img/cart-icon.png" alt="Иконка">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <hr class="footer-line">
        <nav class="footer__navigation">
            <a href="#" class="footer__link">
                Контакты
            </a>
            <a href="#" class="footer__link">
                Оплата
            </a>
            <a href="#" class="footer__link">
                Доставка
            </a>
            <a href="#" class="footer__link">
                Поддержка
            </a>
        </nav>
    </footer>
</body>

</html>