<?php
session_start();
include './public/conn.php';
include './public/user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cartItems = $_SESSION['cart'] ?? [];
$totalItems = 0;
$totalPrice = 0;
$discount = 0;
$promoDiscount = 0;

$promoCode = $_SESSION['promo_code'] ?? null;
if ($promoCode === 'DISCOUNT500') {
    $promoDiscount = 500;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="./assets/script/cart.js" defer></script>
    <script src="./assets/script/account.js" defer></script>
    <title>Корзина</title>
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

    <section class="cart-section-g">
        <div class="container cart__contianer" id="cart-container">
            <div class="menu">
                <?php include './public/services_dropdown.php'; ?>
                <?php include './public/products_dropdown.php'; ?>
                <button class="catalog-button">Поиск по каталогу</button>
            </div>
            <h3 class="title__third">Корзина <span class="color">(<?php echo count($cartItems); ?> товара)</span></h3>
            <?php if (!empty($cartItems)): ?>
                <div class="cart">
                    <div class="cart__wrapper">
                        <ul class="width">
                            <?php foreach ($cartItems as $productId => $item): ?>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                                $stmt->execute(['id' => $productId]);
                                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                                $quantity = $item['quantity'];
                                $totalItems += $quantity;
                                $itemTotalPrice = $product['discounted_price'] * $quantity;
                                $totalPrice += $itemTotalPrice;

                                $itemDiscount = ($product['original_price'] - $product['discounted_price']) * $quantity;
                                $discount += $itemDiscount;
                                ?>
                                <li class="product__container">
                                    <div class="product-left">
                                        <img class="product__img" src="<?php echo htmlspecialchars($product['image_url']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
                                        <div class="product-name__block">
                                            <p class="product__name"><?php echo htmlspecialchars($product['name']); ?></p>
                                            <p class="product__article">Артикул:
                                                <?php echo htmlspecialchars($product['article']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="count__container">
                                        <button class="decrease-quantity" data-id="<?php echo $productId; ?>">-</button>
                                        <?php echo $quantity; ?>
                                        <button class="increase-quantity" data-id="<?php echo $productId; ?>">+</button>
                                    </p>
                                    <div class="product__price">
                                        <p class="product__orig">
                                            <?php echo number_format($product['original_price'], 2, ',', ' ') ?>
                                        </p>
                                        <p class="product__discrount">
                                            <?php echo number_format($product['discounted_price'], 2, ',', ' ') . ' ' . $product['currency']; ?>
                                        </p>
                                    </div>
                                    <button class="remove-from-cart" data-id="<?php echo $productId; ?>"><img
                                            src="./assets/img/trush.png" alt="Удалить"></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="promo-code-container">
                            <input class="promo-code__input" type="text" id="promo-code" placeholder="Введите промокод">
                            <button class="btn__apply" id="apply-promo-code">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                                    fill="none">
                                    <path
                                        d="M18.8378 8.99954C18.8378 9.1551 18.8133 9.30093 18.7643 9.43704C18.7161 9.57315 18.6337 9.69954 18.517 9.81621L10.817 17.5162C10.5837 17.7495 10.3064 17.8662 9.98516 17.8662C9.66471 17.8662 9.38783 17.7495 9.15449 17.5162C8.92116 17.2829 8.80449 17.0107 8.80449 16.6995C8.80449 16.3884 8.92116 16.1162 9.15449 15.8829L14.8712 10.1662L1.80449 10.1662C1.47394 10.1662 1.20171 10.0542 0.987825 9.83021C0.773936 9.60699 0.666992 9.3301 0.666992 8.99955C0.666992 8.66899 0.778603 8.39171 1.00183 8.16771C1.22583 7.94449 1.5031 7.83288 1.83366 7.83288L14.8712 7.83288L9.15449 2.11621C8.92116 1.88288 8.80449 1.61065 8.80449 1.29954C8.80449 0.988432 8.92116 0.716211 9.15449 0.482877C9.38782 0.249546 9.66471 0.132877 9.98516 0.132877C10.3064 0.132877 10.5837 0.249546 10.817 0.482877L18.517 8.18288C18.6337 8.29954 18.7161 8.42593 18.7643 8.56204C18.8133 8.69815 18.8378 8.84399 18.8378 8.99954Z"
                                        fill="url(#paint0_linear_64_953)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_64_953" x1="9.75241" y1="17.8662" x2="9.75241"
                                            y2="0.132877" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E52D27" />
                                            <stop offset="1" stop-color="#B31217" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="cart-summary">
                        <h4 class="title__four">Детали заказа</h4>
                        <div class="column">
                            <p><span class="summary__total item-label"><?php echo $totalItems; ?> товара(ов)</span>
                                <span class="fill-space"></span>
                                <span
                                    class="item-value summary__total"><?php echo number_format($totalPrice, 2, ',', ' ') . ' ' . $product['currency']; ?></span>
                            </p>
                            <p><span class="item-label">Скидка</span>
                                <span class="fill-space"></span>
                                <span
                                    class="item-value">-<?php echo number_format($discount, 2, ',', ' ') . ' ' . $product['currency']; ?></span>
                            </p>
                            <p><span class="item-label">Промокод</span>
                                <span class="fill-space"></span>
                                <span
                                    class="item-value">-<?php echo number_format($promoDiscount, 2, ',', ' ') . ' ' . $product['currency']; ?></span>
                            </p>
                            <p class="total__price-2"><span class="summary__total item-label">Итого</span>
                                <span class="fill-space"></span>
                                <span
                                    class="summary__total item-value"><?php echo number_format($totalPrice - $discount - $promoDiscount, 2, ',', ' ') . ' ' . $product['currency']; ?></span>
                            </p>
                        </div>
                        <button class="btn__checkout" id="checkout">Оформить</button>
                    </div>
                </div>
            <?php else: ?>
                <div class="wrapper" style="gap: 20px">
                    <nav class="account__navigation">
                        <a href="./account.php" class="account__navigation_link">
                            <img src="./assets/img/profile-not.png" alt="Профиль" class="profile-icon">
                            <span class="account__navigation_item">Профиль</span>
                        </a>
                        <a href="./order.php" class="account__navigation_link">
                            <img src="./assets/img/order-not.png" alt="Заказы" class="profile-icon">
                            <span class="account__navigation_item">Заказы</span>
                        </a>
                        <a href="./cart.php" class="account__navigation_link profile-icon__cart">
                            <img src="./assets/img/cart.png" alt="Корзина" class="profile-icon">
                            <span class="account__navigation_item active-1">Корзина</span>
                        </a>
                        <div class="exit">
                            <a href="./public/logout.php" class="exit__btn">
                                <img src="./assets/img/exit.png" alt="Выход" class="exit__icon">
                                Выйти
                            </a>
                        </div>
                    </nav>
                    <div class="empty-cart">
                        <p class="empty-cart__text">Корзина пуста</p>
                        <img class="empty-cart__icon-" src="./assets/img/cart-icon.png" alt="Иконка">
                    </div>
                </div>
            <?php endif; ?>
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
    <script>
            
    </script>
</body>

</html>