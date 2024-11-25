<?php
require_once './public/admin_auth.php';
include './public/conn.php';
include './public/user.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./index.php");
    exit;
}

$stmt = $pdo->query("SELECT users.id, users.email, COUNT(orders.id) AS order_count
                     FROM users
                     LEFT JOIN orders ON users.id = orders.user_id
                     GROUP BY users.id
                     ORDER BY users.email ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT id, name, article, image_url, discounted_price, stock FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <script src="./assets/script/goods-admin.js" defer></script>
    <script src="./assets/script/filter-admin.js" defer></script>
</head>

<body class="body">
    <header class="header">
        <nav class="header__navigation">
            <div class="left-nav">
                <a href="./account.php" class="logo-link">
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
    
    <section class="admin">
        <div class="container">
            <!-- Единственный заголовок, который будет изменяться JavaScript-ом -->
            <h3 id="section-title" class="title__third title__admin">Список пользователей</h3>

            <div class="admin-wrapper">
                <nav class="account__navigation">
                    <a href="#" id="users-link" class="account__navigation_link">
                        <img src="./assets/img/profile-not.png" alt="Профиль" class="profile-icon profile-icon__cart">
                        <span class="account__navigation_item active-1">Пользователи</span>
                    </a>
                    <a href="#" id="products-link" class="account__navigation_link">
                        <img src="./assets/img/order-not.png" alt="Товары" class="profile-icon">
                        <span class="account__navigation_item">Наличие товаров</span>
                    </a>
                    <div class="exit">
                        <a href="./public/logout.php" class="exit__btn">
                            <img src="./assets/img/exit.png" alt="Выход" class="exit__icon">
                            Выйти
                        </a>
                    </div>
                </nav>

                <!-- Список пользователей -->
                <div id="user-list" class="user-list">
                    <div class="admin-search__block">
                        <input class="admin-search search__input" type="text" id="search-input"
                            placeholder="Поиск по почте..." onkeyup="filterUsers()">
                        <svg class="svg-admin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M18.031 16.617L22.314 20.899L20.899 22.314L16.617 18.031C15.0237 19.3082 13.042 20.0029 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20.0029 13.042 19.3082 15.0237 18.031 16.617ZM16.025 15.875C17.2941 14.5699 18.0029 12.8204 18 11C18 7.132 14.867 4 11 4C7.132 4 4 7.132 4 11C4 14.867 7.132 18 11 18C12.8204 18.0029 14.5699 17.2941 15.875 16.025L16.025 15.875Z"
                                fill="white" fill-opacity="0.6" />
                        </svg>
                    </div>
                    <div class="users">
                        <?php foreach ($users as $user): ?>
                            <div class="user-item user-item__admin">
                                <p class="user-list__name"><a
                                        href="./profile.php?user_id=<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['email']); ?></a>
                                </p>
                                <p class="user-list__orders">
                                    <?php echo $user['order_count'] > 0 ? $user['order_count'] . ' заказов' : 'Заказов нет'; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Список товаров -->
                <div id="product-list" class="product-list__admin" style="display: none;">
                    <div class="admin-search__block">
                        <input class="admin-search search__input" type="text" id="product-search"
                            placeholder="Поиск по номеру или наименованию..." onkeyup="filterProducts()">
                        <svg class="svg-admin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M18.031 16.617L22.314 20.899L20.899 22.314L16.617 18.031C15.0237 19.3082 13.042 20.0029 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20.0029 13.042 19.3082 15.0237 18.031 16.617ZM16.025 15.875C17.2941 14.5699 18.0029 12.8204 18 11C18 7.132 14.867 4 11 4C7.132 4 4 7.132 4 11C4 14.867 7.132 18 11 18C12.8204 18.0029 14.5699 17.2941 15.875 16.025L16.025 15.875Z"
                                fill="white" fill-opacity="0.6" />
                        </svg>
                    </div>
                    <div class="products products-admin__wrapper">
                        <?php foreach ($products as $product): ?>
                            <div class="product-item product__container">
                            <img class="product__img" src="<?php echo htmlspecialchars($product['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
                                <div class="product-details product-name__block">
                                    <p class="product__name"><?php echo htmlspecialchars($product['name']); ?></p>
                                    <p class="product__article">Артикул:
                                        <?php echo htmlspecialchars($product['article']); ?>
                                    </p>
                                </div>
                                <div class="count__container">
                                    <button class="decrease-quantity" data-id="<?php echo $product['id']; ?>">-</button>
                                    <span class="quantity"><?php echo $product['stock']; ?></span>
                                    <button class="increase-quantity" data-id="<?php echo $product['id']; ?>">+</button>
                                </div>
                                <p class="product__discrount">
                                    <?php echo number_format($product['discounted_price'], 0, ',', ' '); ?> ₽
                                </p>
                                <button class="remove-product__admin" data-id="<?php echo $product['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                                    <path d="M5 0V1H0V3H1V16C1 16.5304 1.21071 17.0391 1.58579 17.4142C1.96086 17.7893 2.46957 18 3 18H13C13.5304 18 14.0391 17.7893 14.4142 17.4142C14.7893 17.0391 15 16.5304 15 16V3H16V1H11V0H5ZM3 3H13V16H3V3ZM5 5V14H7V5H5ZM9 5V14H11V5H9Z" fill="white" fill-opacity="0.7"/>
                                </svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- JavaScript для переключения блоков -->
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const userList = document.getElementById('user-list');
            const productList = document.getElementById('product-list');
            const sectionTitle = document.getElementById('section-title');

            const usersLink = document.getElementById('users-link');
            const productsLink = document.getElementById('products-link');

            // Обработчик клика для показа списка пользователей
            usersLink.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Обновляем заголовок
                sectionTitle.textContent = 'Список пользователей';

                // Переключаем видимость блоков
                userList.style.display = 'block';
                productList.style.display = 'none';

                // Добавляем активные классы
                usersLink.querySelector('.account__navigation_item').classList.add('active-1');
                productsLink.querySelector('.account__navigation_item').classList.remove('active-1');

                usersLink.querySelector('.profile-icon').classList.add('profile-icon__cart');
                productsLink.querySelector('.profile-icon').classList.remove('profile-icon__cart');
            });

            // Обработчик клика для показа списка товаров
            productsLink.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Обновляем заголовок
                sectionTitle.textContent = 'Список товаров';

                // Переключаем видимость блоков
                userList.style.display = 'none';
                productList.style.display = 'block';

                // Добавляем активные классы
                productsLink.querySelector('.account__navigation_item').classList.add('active-1');
                usersLink.querySelector('.account__navigation_item').classList.remove('active-1');

                productsLink.querySelector('.profile-icon').classList.add('profile-icon__cart');
                usersLink.querySelector('.profile-icon').classList.remove('profile-icon__cart');
            });
        });
    </script>

</body>

</html>
