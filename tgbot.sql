-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 28 2022 г., 19:56
-- Версия сервера: 5.7.34
-- Версия PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tgbot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `vid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `inventory`
--

INSERT INTO `inventory` (`id`, `uid`, `vid`) VALUES
(7, 477621296, 35),
(8, 571786140, 35),
(9, 831283361, 35),
(12, 831283361, 37),
(13, 571786140, 37),
(14, 933786490, 37),
(16, 335063348, 37),
(17, 571786140, 41),
(18, 477621296, 41),
(19, 831283361, 41),
(21, 477621296, 42),
(23, 571786140, 42),
(24, 831283361, 42);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `state` varchar(200) DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `username` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `state`, `admin`, `username`, `name`) VALUES
(335063348, 'none', 0, 'taras_ivv', 'Тэрэс'),
(477621296, 'none', 0, '', 'Александр'),
(488048706, 'none', 0, 'e3gar1o', 'Игорь'),
(571786140, 'none', 0, 'rilysann', 'Mivel'),
(609022216, 'none', 0, 'Koreon4ik', 'Кореон'),
(831283361, 'none', 0, 'datadaddto', 'Стасян'),
(933786490, 'none', 0, 'Mihbo2006', 'Михайло'),
(1005024016, 'none', 1, 'defProger', 'Admin'),
(1066553725, 'none', 0, 'DriZeUwU', 'Дима');

-- --------------------------------------------------------

--
-- Структура таблицы `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `price` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `videos`
--

INSERT INTO `videos` (`id`, `path`, `name`, `descr`, `price`) VALUES
(35, 'BAACAgIAAxkBAAIZvGMIN_B9aHxalYtMPJLZlpoAAQqyZwACkxwAAhRGUUu790k0A9n0ZikE', 'Переменные переменных', 'Редко используемая функция php, ккрайне полезная в некоторых ситуациях', 15),
(36, 'BAACAgIAAxkBAAIZ0WMI3mrNoKwrx6gqMlqAb1tFvFO_AAKVHAACFEZRS_9rgpSOEzhYKQQ', 'протоколы, пакет данных, ftp, webhooks', '', 100),
(37, 'BAACAgIAAxkBAAIZ2WMKL017aJEF6t_HPWadqaDvhaZsAAKXHAACFEZRS0IGs1z5H6e0KQQ', 'Стандарты вёрстки', 'Общие стили текста, принцип ряд колонка, правильная запись тегов, одинарные теги', 50),
(38, 'BAACAgIAAxkBAAIZ62MKcadRRaJIo8_IFlXy1qSKS14GAAIBHgACFEZZS43lKJkx1MzwKQQ', 'Sass', 'Sass scss - плюсы препроцессоров css, почему их используют?', 60),
(39, 'BAACAgIAAxkBAAIZ8WMKcpokMy0qzuxz3L89TFdV8wnKAAIDHgACFEZZS0JXYMIm9JJIKQQ', 'Position: relative, Position: absolute', 'Как они совмещаются, кому это свойства задаются, для чего это надо', 100),
(40, 'BAACAgIAAxkBAAIZ92MKc8dEAuytgnlNcqfC_3gek6LpAALQHQACryHxSmVbWihjrRymKQQ', 'Зачем нужен OOП? PHP - ООП', 'Тут объясняется для чего нужен ооп, и какие есть вариации его применения: Трейты, абстрактные классы, интерфейсы, наследование.', 100),
(41, 'BAACAgIAAxkBAAIZ_WMKdJ9MsbqvYQfRxzrlPHik2J8sAAIiJAACucYhSJ8xw23F48DzKQQ', 'Как копировать с фигмы. Подключение шрифтов.', '', 60),
(42, 'BAACAgIAAxkBAAIaBGMKd1PBSymDB5qLdCN8xR_icoYvAAIEJAACucYhSOP0KaB55LWZKQQ', 'Размеры текста вместо px. REM, EM.', '', 50);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `videos`
--
ALTER TABLE `videos`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
