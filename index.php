<?php
include './public/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/main.css">
    <script src="./assets/script/modal.js" defer></script>
    <script src="./assets/script/burger.js"></script>
    <title>Главная</title>
</head>

<body>
    <header class="header">
        <nav class="header__navigation">
            <a href="#" class="logo-link">
                <img src="./assets/img/logo.svg" alt="Логотип" class="logo">
            </a>

            <!-- Иконка бургера для мобильной версии -->
            <div class="burger-menu" onclick="toggleMenu()">
                <span class="burger-icon">&#9776;</span> <!-- Символ иконки бургера -->
            </div>

            <!-- Основное меню для десктопной версии -->
            <ul class="menu__list">
                <li class="menu__list_item">
                    <a href="#" class="menu__list_link">Контакты</a>
                </li>
                <li class="menu__list_item">
                    <a href="#" class="menu__list_link">Оплата</a>
                </li>
                <li class="menu__list_item">
                    <a href="#" class="menu__list_link">Доставка</a>
                </li>
                <li class="menu__list_item">
                    <a href="#" class="menu__list_link">О нас</a>
                </li>
            </ul>

            <!-- Выпадающее меню для мобильной версии -->
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#" class="menu__list_link">Контакты</a>
                <a href="#" class="menu__list_link">Оплата</a>
                <a href="#" class="menu__list_link">Доставка</a>
                <a href="#" class="menu__list_link">О нас</a>
            </div>
        </nav>
    </header>
    <section class="hero">
        <div class="container hero-container hero-mob">
            <div class="left-block">
                <h1 class="title__first">
                    <span class="title__first-up">
                        Olympecs –
                    </span>
                    продукт новой эпохи
                </h1>
                <p class="hero__description">
                    Мы предлагаем своим фклиентам запчасти и комплектующие для производственного транспортирующего и
                    конвейерного оборудования. Широкий выбор продукции.
                </p>
                <a href="#" class="btn__sign-in">
                    Войти или зарегистрироваться
                </a>
            </div>
            <img src="./assets/img/general-img.png" alt="Изображение" class="hero__img">
        </div>
    </section>
    <div class="form-container">
        <form action="./public/login-handler.php" method="POST" class="form__auth">
            <h3 class="form__title">Войти или зарегистрироваться</h3>
            <label for="login" class="form__auth_label form__auth_label-login">
                <span class="form__auth_span">Логин</span>
                <input type="email" class="form__auth_input-login" name="email" required>
            </label>
            <label for="password" class="form__auth_label form__auth_label-password">
                <span class="form__auth_span">Пароль</span>
                <input type="password" class="form__auth_input-password" name="password" required>
            </label>
            <div class="block-1">
                <span class="form__auth_description">
                    Нажимая кнопку, я подтверждаю своё согласие на <a href="#" class="form__auth_link">
                        обработку персональных данных
                    </a>
                </span>
            </div>
            <button type="submit" class="form__auth_btn">Войти или зарегистрироваться</button>
        </form>
    </div>
</body>

</html>