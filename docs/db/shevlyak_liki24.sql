-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: shevlyak.mysql.ukraine.com.ua
-- Время создания: Окт 02 2019 г., 00:58
-- Версия сервера: 5.7.16-10-log
-- Версия PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shevlyak_liki24`
--

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_info`
--

CREATE TABLE `delivery_info` (
  `delivery_windows_day_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL DEFAULT '0',
  `delay` int(11) DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_windows`
--

CREATE TABLE `delivery_windows` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_windows_day`
--

CREATE TABLE `delivery_windows_day` (
  `id` int(11) NOT NULL,
  `delivery_windows_id` int(11) NOT NULL,
  `day_of_the_week` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `delivery_info`
--
ALTER TABLE `delivery_info`
  ADD PRIMARY KEY (`delivery_windows_day_id`);

--
-- Индексы таблицы `delivery_windows`
--
ALTER TABLE `delivery_windows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `delivery_windows_day`
--
ALTER TABLE `delivery_windows_day`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `delivery_windows`
--
ALTER TABLE `delivery_windows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `delivery_windows_day`
--
ALTER TABLE `delivery_windows_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
