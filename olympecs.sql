-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 31, 2024 at 12:23 PM
-- Server version: 8.0.35
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olympecs`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_number` varchar(10) NOT NULL,
  `total_items` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status_order` enum('Новый','Отменен','Завершен','Оформлен','Доставлен','В процессе доставки','Оплачен') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Новый',
  `payment_status` enum('Оплачен','Не оплачен') DEFAULT 'Не оплачен',
  `discount` decimal(10,2) DEFAULT '0.00',
  `promo_code` varchar(50) DEFAULT NULL,
  `final_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `total_items`, `total_price`, `status_order`, `payment_status`, `discount`, `promo_code`, `final_total`, `created_at`, `user_id`) VALUES
(21, '62886', 1, 21500.00, 'Новый', 'Не оплачен', 1600.00, NULL, 10000.00, '2024-10-30 22:58:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '₽',
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Заполнение таблицы `products`
INSERT INTO `products` (`id`, `name`, `article`, `image_url`, `original_price`, `discounted_price`, `currency`, `stock`, `created_at`) VALUES
(1, 'Транспортные ленты с ПВХ, ПУ и силиконовым покрытием', '1', 'https://олимпекс.рф/wp-content/uploads/2017/11/транспортерные-ленты-с-пвх-пу-и-силиконовым-покрытием-500x500.jpg', 1000.00, 1000.00, '₽', 1000, CURRENT_TIMESTAMP),
(2, 'Резинотканевая конвейерная лента', '1', 'https://олимпекс.рф/wp-content/uploads/2017/11/резинотканевая-лента-500x464.jpeg', 1000.00, 1000.00, '₽', 1000, CURRENT_TIMESTAMP),
(3, 'Шевронная лента транспортерная', '1', 'https://олимпекс.рф/wp-content/uploads/2017/11/шевронная-лента-транспортерная.jpg', 1000.00, 1000.00, '₽', 1000, CURRENT_TIMESTAMP),
(4, 'Пластина силиконовая термостойкая', '1', 'https://олимпекс.рф/wp-content/uploads/2017/11/пластина-силиконовая-термостойкая-200x200.jpeg', 1000.00, 1000.00, '₽', 1000, CURRENT_TIMESTAMP),
(5, 'Силиконовые шнуры', '1', 'https://олимпекс.рф/wp-content/uploads/2017/11/силиконовые-шнуры-200x200.jpg', 1000.00, 1000.00, '₽', 1000, CURRENT_TIMESTAMP);
-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(1, 'Установка оборудования', 'Монтаж и установка промышленного оборудования', 5000.00, '2024-10-30 13:52:35'),
(2, 'Консультация инженера', 'Консультация по вопросам оборудования и его работы', 1500.00, '2024-10-30 13:52:35'),
(3, 'Плановое обслуживание', 'Регулярное обслуживание оборудования для предотвращения поломок', 3000.00, '2024-10-30 13:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `surname`, `phone`, `email`, `password`, `role`) VALUES
(4, 'user', 'user', 'userovich', '777777777', 'ivonov@gmail.com', '$2y$10$WAv4c39KHEPBDkerNEfDV.inhG/WleO85WUOzNGbHYpv.6R8xpZly', 'user'),
(5, '', NULL, NULL, NULL, 'admin@gmail.com', '$2y$10$Sk86YReF4K6cGAqarkMauuEAQzCQGNy9ZOUTG66jORuAq/JOZ/W7W', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
