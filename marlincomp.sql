-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 12 2019 г., 09:28
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marlincomp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `text` text NOT NULL,
  `skip` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `date`, `text`, `skip`, `user_id`) VALUES
(1, '2019-10-15', 'проверка...', 1, 1),
(2, '2019-10-16', 'таааакс...', 1, 1),
(3, '2019-11-11', 'новый коммент', 1, 8),
(4, '2019-11-11', '1111111111111111', 1, 8),
(5, '2019-11-11', '22222222222222222', 1, 8),
(6, '2019-11-11', '33333333333333333333', 1, 8),
(7, '2019-11-11', '444444444444444444444444', 1, 8),
(8, '2019-11-11', '555555555555555555555555555555555', 1, 8),
(9, '2019-11-11', '6666666666666666666666666666666666', 1, 8),
(10, '2019-11-11', '7777777777777777777777777777777', 1, 8),
(11, '2019-11-11', '8888888888888888888888888888888', 1, 8),
(12, '2019-11-11', '9999999999999999999999999999999999999999', 1, 8),
(13, '2019-11-11', 'фффффффффффффффф', 1, 8),
(14, '2019-11-11', 'как', 1, 8),
(15, '2019-11-11', 'ыыыыыыыыыыыыыыыыы', 1, 8),
(16, '2019-11-11', 'аааааааааааааааааааа', 1, 8),
(17, '2019-11-11', 'аааааааааааааааааааа', 1, 8),
(18, '2019-11-11', 'аааааааааааааааааааа', 1, 8),
(19, '2019-11-11', 'аааааааааааааааааааа', 1, 8),
(20, '2019-11-11', 'ввввв', 1, 8),
(21, '2019-11-11', '1111111111111111111', 1, 8),
(23, '2019-11-11', 'ццццццццццц', 1, 8),
(24, '2019-11-11', 'saw', 1, 8),
(26, '2019-11-12', 'ccccccccccccccfccccccccccccccc', 1, 1),
(27, '2019-11-12', 'dfgsdgdd', 1, 1),
(29, '2019-11-12', 'dsssssssssssssssssssssssssssssssssss', 1, 12),
(30, '2019-11-12', 'всё работает!)', 1, 8),
(31, '2019-11-12', 'действительно работает....', 1, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `registered` int(10) UNSIGNED NOT NULL,
  `last_login` int(10) UNSIGNED DEFAULT NULL,
  `force_logout` mediumint(7) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(1, 'alexeysannikov22@mail.com', '$2y$10$ayySTKeZAPJassMVJ9EK.uMGfdUtkoUWF3raVQRUgq43u4C0W49t2', 'Leha SAW', 0, 1, 1, 0, 1573239530, 1573506764, 1),
(8, 'alexeysannikov22@gmail.com', '$2y$10$qJNjrqHmrhsMM/quBO8i6O7HwNiULPMFnI2vprUq4HS4r9gwMg962', 'Admin', 0, 1, 1, 1, 1573463996, 1573539509, 0),
(13, 'il@il.com', '$2y$10$Pqv2VDybAJ6bAUFV9el39..gMbpFvI2q2/jsg8fVVwmZO1p18WvL6', 'Гость', 0, 1, 1, 0, 1573539804, 1573539913, 0),
(12, 'alexeysannikov22@il.com', '$2y$10$en9xKuXrhXc0uk.2ag.DbO0JgXcHXLpX6.OrHor3.aHIX2OZ3wrZm', 'alex', 0, 1, 1, 0, 1573519147, 1573519202, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `userscom`
--

CREATE TABLE `userscom` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no-user.jpg',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `userscom`
--

INSERT INTO `userscom` (`id`, `name`, `image`, `user_id`) VALUES
(1, 'Leha SAW', '5dc9fd36ad653.jpg', 1),
(2, 'Admin', '5dca4eec34128.png', 8),
(4, 'alex', '5dca4e9073000.jpg', 12),
(5, 'Гость', 'no-user.jpg', 13);

-- --------------------------------------------------------

--
-- Структура таблицы `users_confirmations`
--

CREATE TABLE `users_confirmations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_confirmations`
--

INSERT INTO `users_confirmations` (`id`, `user_id`, `email`, `selector`, `token`, `expires`) VALUES
(1, 1, 'alexeysannikov@mail.com', 'Q7oA2rMuoAyeLYy2', '$2y$10$HZKgYRExQp0g0bHj4UUiDO4YGRJx7RxwhRLBjQpSiONvEx/4iHTZK', 1573325930),
(11, 11, 'alex@gmail.com', 'EIKVi4HInmsnDCo9', '$2y$10$Yqk.0KMoiTFyiNsEp5j0JeCLJC9kzWVaO6vvpCZyJOA4mgrMHNbfe', 1573563024),
(10, 10, 'alex@gmail.com', 'd1c5ktjEGXV0mPfe', '$2y$10$0y7n48Wm27ms3cEUziKBUutX79H6s.j1ie6Upwduuj7tEfOVf4VIe', 1573562920),
(9, 9, 'alex@gmail.com', 'DJRC68tyfjYc3axz', '$2y$10$oYzvab7nredzDLGuL8HbHeMpco1vM847n8WEs0YrcUkWCZ6Qz9nNa', 1573562524),
(7, 7, 'alexeysannikov22@gmail.com', 'UNRDrRYAXKRhvIiX', '$2y$10$ZQJn7f40XMy.S0vi1.K1Ze8jz3DKTh6dTYE9Og/4p0X.JGeckGmEO', 1573550238),
(14, 12, 'alexeysannikov@il.com', 'SVJrkqumyGn4dfO1', '$2y$10$g7a.NIVzROKPTY/fbXJMvumsaRlGZF3.rCZkYvDtrXmHyVolbXE3O', 1573605649);

-- --------------------------------------------------------

--
-- Структура таблицы `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_resets`
--

CREATE TABLE `users_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int(10) UNSIGNED NOT NULL,
  `expires_at` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('pm9DIO1-R3HkbKMpWAz6tiQ6qB0y0POpZni3nxK7uuM', 0.00793981, 1573517470, 1573690270),
('3VrMU354Y_uVX22KD-pensoGyl9P8xi0fs5YhJZGrOk', 10.1, 1573516724, 1573545523),
('58eR9CVFAmOAtE65A0FnkP_xopSpJkLnNlMC-7Z-MpY', 499, 1573478785, 1573651585),
('OMhkmdh1HUEdNPRi-Pe4279tbL5SQ-WMYf551VVvH8U', 18.0267, 1573539848, 1573575848),
('7aBNv7Ns6h1BUgMhjpzPaH0ZsmNy3kQKYQTct6vNshg', 28.025, 1573477244, 1573549244),
('J12uR7YmKZE32lyh88-Sx78F0CtmLq0z1FRBSzZDUCk', 28.025, 1573477244, 1573549244),
('HIJQJPUQ2qyyTt0Q7_AuZA0pXm27czJnqpJsoA5IFec', 49, 1573539877, 1573611877),
('PZ3qJtO_NLbJfRIP-8b4ME4WA3xxc6n9nbCORSffyQ0', 1.474, 1573539812, 1573971812),
('QduM75nGblH2CDKFyk0QeukPOwuEVDAUFE54ITnHM38', 67.4249, 1573539913, 1574079913),
('4SIEqVSrUfbHDykIMNzQgj4bibgxQ9QnYLpxlq-85Dk', 1.02853, 1573519249, 1574037649),
('Sr_bvhSfxke3RYaSTlbsDqRqkute3GtrG7NHMFBhwv8', 29, 1573517404, 1573589404),
('yudPAHAmZxyIeuGqPDHkWhg0s87RI0GsCy4gGyWUUm4', 29, 1573517404, 1573589404),
('BMRCI-sffgcpKJOeUaX4Eaf2eQbwqRECBzSFxOnwYIo', 29, 1573519188, 1573591188),
('YiXsSh-ga8cuM53cSkUciF5Z8Kwf6dzhP1qhQRjLu_I', 29, 1573519188, 1573591188),
('cUP3Rk5T08qq46rfTnh6f2Gb9SczC6v5dw3izhcqvLY', 0, 1573519249, 1573692049),
('FiyCFXyB80vb6Eg8Eo00jvRgcQkE9Jmi5b6a0PVSqeM', 498.139, 1573539848, 1573712648),
('ZMM9khKF_nKQnGJV1VP2jeDvdfhIxAitXxGMQLgtH5M', 29, 1573539877, 1573611877),
('sbaVQF1GafCy6En-p_2AzWUIPnfK3tkeE62uDOvmSkA', 29, 1573539877, 1573611877);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `userscom`
--
ALTER TABLE `userscom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Индексы таблицы `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `userscom`
--
ALTER TABLE `userscom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userscom` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
