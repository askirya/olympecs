<?php
session_start();
include './public/conn.php';
include './public/user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT name, last_name, surname, phone, email FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./assets/style/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./assets/script/account.js" defer></script>
    <script></script>
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
    <section class="account">
        <div class="container">
            <div class="menu">
                <?php include './public/services_dropdown.php'; ?>
                <?php include './public/products_dropdown.php'; ?>
                <button class="catalog-button">Поиск по каталогу</button>
            </div>
            <h2 class="title__second">Профиль</h2>
        </div>
        <div class="container account-container">
            <nav class="account__navigation">
                <a href="./account.php" class="account__navigation_link">
                    <img src="./assets/img/profile.png" alt="Профиль" class="profile-icon">
                    <span class="account__navigation_item active-1">Профиль</span>
                </a>
                <a href="./order.php" class="account__navigation_link">
                    <img src="./assets/img/order-not.png" alt="Профиль" class="profile-icon">
                    <span class="account__navigation_item">Заказы</span>
                </a>
                <a href="./cart.php" class="account__navigation_link">
                    <img src="./assets/img/cart.png" alt="Профиль" class="profile-icon">
                    <span class="account__navigation_item">Корзина</span>
                </a>
                <div class="exit">
                    <a href="./public/logout.php" class="exit__btn">
                        <img src="./assets/img/exit.png" alt="Выход" class="exit__icon">
                        Выйти
                    </a>
                </div>
            </nav>
            <div class="account-center">
                <div class="profile-field <?php echo (empty($userData['name']) || empty($userData['last_name']) || empty($userData['surname'])) ? 'edit-mode' : 'view-mode'; ?>"
                    id="personal-data">
                    <h3 class="title__third">Личные данные</h3>
                    <div class="flex-toggle">
                        <label class="label__personal">Имя:</label>
                        <span class="label__personal span__personal"
                            id="display-name"><?php echo htmlspecialchars($userData['name'] ?? ''); ?></span>
                        <input class="input__personal" type="text" id="name"
                            value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>">
                    </div>
                    <div class="flex-toggle">
                        <label class="label__personal">Фамилия:</label>
                        <span class="label__personal span__personal"
                            id="display-last_name"><?php echo htmlspecialchars($userData['last_name'] ?? ''); ?></span>
                        <input class="input__personal" type="text" id="last_name"
                            value="<?php echo htmlspecialchars($userData['last_name'] ?? ''); ?>">
                    </div>
                    <div class="flex-toggle">
                        <label class="label__personal">Отчество:</label>
                        <span class="label__personal span__personal"
                            id="display-surname"><?php echo htmlspecialchars($userData['surname'] ?? ''); ?></span>
                        <input class="input__personal" type="text" id="surname"
                            value="<?php echo htmlspecialchars($userData['surname'] ?? ''); ?>">
                    </div>
                    <div class="btn-con">
                        <button class="btn-save" id="save-personal-data" onclick="saveChanges('personal-data')"
                            disabled>Сохранить</button>
                        <?php if (!empty($userData['name']) && !empty($userData['last_name']) && !empty($userData['surname'])): ?>
                            <button class="btn-change" id="edit-personal-data"
                                onclick="toggleEditMode('personal-data')">Изменить</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="account-right">
                <div class="profile-field profile-field-2 <?php echo empty($userData['phone']) ? 'edit-mode' : 'view-mode'; ?>"
                    id="contact-phone">
                    <h3 class="title__third">Контактный телефон</h3>
                    <span id="display-phone"><?php echo htmlspecialchars($userData['phone'] ?? ''); ?></span>
                    <input class="input__personal" type="text" id="phone"
                        value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>">
                    <div class="btn-con">
                        <button class="btn-save" id="save-contact-phone" onclick="saveChanges('contact-phone')"
                            disabled>Сохранить</button>
                        <?php if (!empty($userData['phone'])): ?>
                            <button class="btn-change" id="edit-contact-phone"
                                onclick="toggleEditMode('contact-phone')">Изменить</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="profile-field profile-field-2 <?php echo empty($userData['email']) ? 'edit-mode' : 'view-mode'; ?>"
                    id="contact-email">
                    <h3 class="title__third">Почта</h3>
                    <span id="display-email"><?php echo htmlspecialchars($userData['email'] ?? ''); ?></span>
                    <input class="input__personal" type="email" id="email"
                        value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
                    <button class="btn-save" id="save-contact-email" onclick="saveChanges('contact-email')"
                        disabled>Сохранить</button>
                    <button class="btn-change" id="edit-contact-email"
                        onclick="toggleEditMode('contact-email')">Изменить</button>
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
    <script src="./assets/script/personal.js" defer></script>
</body>

</html>