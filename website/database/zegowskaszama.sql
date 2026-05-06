-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 06, 2026 at 02:39 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zegowskaszama`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `discounted_products`
--

CREATE TABLE `discounted_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `discount_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounted_products`
--

INSERT INTO `discounted_products` (`id`, `discount_id`, `product_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 3),
(4, 4, 4),
(5, 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `discounts`
--

CREATE TABLE `discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `procent` tinyint(3) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `procent`, `start_date`, `end_date`) VALUES
(1, 20, '2020-01-01 00:00:00', '2030-01-01 00:00:00'),
(2, 50, '2020-01-01 00:00:00', '2030-01-01 00:00:00'),
(3, 50, '2020-01-01 00:00:00', '2024-01-01 00:00:00'),
(4, 20, '2028-01-01 00:00:00', '2030-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','ready','claimed','canceled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('food','drink','school') DEFAULT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock` int(10) NOT NULL DEFAULT -1,
  `is_available` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `type`, `price`, `created_at`, `updated_at`, `stock`, `is_available`, `is_active`, `img`) VALUES
(1, 'Bułka z szynką', 'Bułka z szynką i masłem', 'food', 2.99, '2026-05-05 12:49:54', '2026-05-06 11:23:26', -1, 1, 1, 'Bułka z szynką.png'),
(2, 'Bułka z serem', 'Bułka z serem i masłem', 'food', 2.99, '2026-05-05 13:22:03', '2026-05-06 11:23:26', -1, 1, 1, 'Bułka z serem.png'),
(3, 'Bułka z szynką i serem', 'Bułka z szynką, serem i masłem', 'food', 3.99, '2026-05-05 13:22:36', '2026-05-06 11:23:26', -1, 1, 1, 'Bułka z szynką i serem.png'),
(4, 'Bułka Gołosza', 'Bułka z szynką, serem, sałatą i ogórkiem', 'food', 4.99, '2026-05-05 13:23:15', '2026-05-06 11:23:26', -1, 1, 1, 'Bułka Gołosza.png'),
(5, 'HotDog', 'Hotdog z dowolnym sosem', 'food', 4.99, '2026-05-06 07:48:47', '2026-05-06 11:23:26', -1, 1, 1, 'HotDog.png'),
(6, 'DoubleDog', 'Hotdog z dwiema parówkami i dowolnym sosem', 'food', 6.99, '2026-05-06 07:49:26', '2026-05-06 11:23:26', -1, 1, 1, 'DoubleDog.png'),
(7, 'Tymbark jabłko wiśnia 0,25l', 'Tymbark jabłko wiśnia 250ml w szklanej butelce', 'drink', 2.99, '2026-05-06 07:50:58', '2026-05-06 08:50:48', 20, 1, 1, 'JABWIS025l.png'),
(8, 'Tymbark jabłko wiśnia 0,5l', 'Tymbark jabłko wiśnia 500ml w małej plastikowej butelce', 'drink', 3.99, '2026-05-06 08:45:21', '2026-05-06 09:15:42', 1, 1, 1, 'JABWIS05l.png'),
(9, 'Tymbark jabłko wiśnia 2l', 'Tymbark jabłko wiśnia 2litry w dużej plastikowej butelce', 'drink', 4.99, '2026-05-06 08:46:10', '2026-05-06 08:51:01', 0, 1, 1, 'JABWIS2l.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `failed_attempts` tinyint(1) NOT NULL DEFAULT 0,
  `last_failed_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `last_login`, `is_active`, `failed_attempts`, `last_failed_login`) VALUES
(1, '2', '2@2', '$2y$10$rrWRVX//ZWv4Lfv2C1DWuubpChOsX2nNof2cADp.6g9pJgBGrNsaK', 'admin', '2026-05-05 12:36:28', '2026-05-06 06:57:24', '2026-05-06 08:57:24', 1, 0, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `discounted_products`
--
ALTER TABLE `discounted_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dp_products` (`product_id`),
  ADD KEY `dp_discounts` (`discount_id`);

--
-- Indeksy dla tabeli `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `op_orders` (`order_id`),
  ADD KEY `op_products` (`product_id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_users` (`user_id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discounted_products`
--
ALTER TABLE `discounted_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `discounted_products`
--
ALTER TABLE `discounted_products`
  ADD CONSTRAINT `dp_discounts` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `dp_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD CONSTRAINT `op_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `op_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
