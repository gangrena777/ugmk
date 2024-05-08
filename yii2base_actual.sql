-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Сен 11 2023 г., 18:35
-- Версия сервера: 5.7.42
-- Версия PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii2base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `population` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `code`, `name`, `population`) VALUES
(26, 'GRB', 'Great  Britain', 123000000),
(27, 'CAN', 'CANADA', 56500000),
(28, 'USA', 'Utated States of America', 476000000),
(29, 'RU', 'Russia', 145000000),
(40, 'CUBA', 'CUBA', 5555),
(41, 'LITVA', 'LITVA', 66788),
(42, 'FRG', 'RFG', 6777),
(43, 'IND', 'india', 150000000),
(44, 'BRA', 'brazil', 450000),
(45, 'UUU', 'uuu', 677889899),
(46, 'CHILY', 'chily', 3344),
(48, 'CON', 'congo', 334455);

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` int(255) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `doc_path` varchar(255) NOT NULL,
  `doc_object_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `doc_name`, `doc_path`, `doc_object_id`) VALUES
(1, 'freya-tur.ru.error.log', 'upload/documents/freya-tur.ru.error.log', 5),
(2, 'contract_186965713.pdf', 'upload/documents/contract_186965713.pdf', 21),
(3, 'cli.php', 'upload/documents/cli.php', 7),
(4, '2021-02-10_tdkrasin.ru_Циклические-гиперссылки2_Исходящие-ссылки_Таблица_4412_Netpeak-Spider_193748.xlsx', 'upload/documents/2021-02-10_tdkrasin.ru_Циклические-гиперссылки2_Исходящие-ссылки_Таблица_4412_Netpeak-Spider_193748.xlsx', 7),
(5, 'Payment_479319485.pdf', 'upload/documents/Payment_479319485.pdf', 7),
(6, 'contract_186965713.pdf', 'upload/documents/contract_186965713.pdf', 23),
(7, 'смета шаумяна 104а (1).docx', 'upload/documents/смета шаумяна 104а (1).docx', 24),
(8, 'contract_186965713.pdf', 'upload/documents/contract_186965713.pdf', 24),
(9, 'store-2630111-202102171538.xls', 'upload/documents/store-2630111-202102171538.xls', 24),
(10, 'api.php', 'upload/documents/api.php', 24),
(11, 'store-2630111-202102171538.csv', 'upload/documents/store-2630111-202102171538.csv', 24),
(12, '6966909__2021-01-07__2021-01-07.csv.zip', 'upload/documents/6966909__2021-01-07__2021-01-07.csv.zip', 24),
(13, 'photo5393527168069382844.jpg', 'upload/documents/photo5393527168069382844.jpg', 24),
(14, 'index.php', 'upload/documents/index.php', 5),
(15, '2 - Принц. схема АПТ.pdf', 'upload/documents/2 - Принц. схема АПТ.pdf', 5),
(16, 'modbus_web_project03.zip.rar', 'upload/documents/modbus_web_project03.zip.rar', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1693852456);

-- --------------------------------------------------------

--
-- Структура таблицы `object`
--

CREATE TABLE `object` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `addres` varchar(255) NOT NULL,
  `communications` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `object`
--

INSERT INTO `object` (`id`, `name`, `addres`, `communications`, `info`, `description`) VALUES
(5, 'qwerttttttty', 'ул.березовский ул.гагарина 27', '000-000-000', '<p><strong><em>bla bla bla</em></strong></p>\r\n\r\n<p style=\"text-align:justify\"><strong><em><span style=\"font-family:times new roman,times,serif\">qwer ertt gtyyyyyyyyy<sup>66666<sub>7777777</sub></sup></span></em><span style=\"font-family:times new roman,times,serif\">rrrtyyyyyyy</span></strong></p>\r\n', 'qazwsxedc bgy _iu87gh'),
(7, 'ТЕСТОВЫЙ 5', 'ул.Тестовая', '6667899087', '<h2 style=\"font-style:italic\">Какой то текст</h2>\r\n', 'фывапролдж мпе'),
(23, 'zzzzz', 'zzzzz zzzzz', 'zzz123 345zzzzz', '<p>zzzzzzzzzzzzzzzz zzzzzzzzzzzzzzz&nbsp;</p>\n\n<p>zzzzzzzzzzzzzzz&nbsp;</p>\n\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:500px\">\n	<tbody>\n		<tr>\n			<td>qwerty</td>\n			<td>ytrew</td>\n		</tr>\n		<tr>\n			<td>qaz</td>\n			<td>zaq</td>\n		</tr>\n		<tr>\n			<td>wsx</td>\n			<td>&nbsp;</td>\n		</tr>\n	</tbody>\n</table>\n\n<p><a id=\"##\" name=\"##\"></a></p>\n', 'zzzzz'),
(24, 'jjjj', 'jjjjj', 'jjjjj', '<p>jjjjj</p>\r\n', 'jjjj');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `object_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `name`, `path`, `object_id`) VALUES
(4, 'advantages_00.png', 'upload/photos/advantages_00.png', 16),
(5, 'advantages_01.png', 'upload/photos/advantages_01.png', 16),
(6, 'advantages_02.png', 'upload/photos/advantages_02.png', 16),
(7, 'card.png', 'upload/photos/card.png', 20),
(8, 'card.png', 'upload/photos/card.png', 21),
(9, 'text_00.png', 'upload/photos/text_00.png', 22),
(10, 'text_01.png', 'upload/photos/text_01.png', 22),
(13, 'blank.png', 'upload/photos/blank.png', 7),
(14, 'возврат товара.jpg', 'upload/photos/возврат товара.jpg', 22),
(15, 'logo.png', 'upload/photos/logo.png', 23),
(19, 'ксперт.jpg', 'upload/photos/ксперт.jpg', 5),
(20, 'ла.png', 'upload/photos/ла.png', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `testmodel`
--

CREATE TABLE `testmodel` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `testmodel`
--

INSERT INTO `testmodel` (`id`, `name`, `description`, `text`) VALUES
(1, 'name_2', '333wwwe3333', '334de44444'),
(2, 'name_3333', '333wwwe3333', '334de44444');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `testmodel`
--
ALTER TABLE `testmodel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `object`
--
ALTER TABLE `object`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `testmodel`
--
ALTER TABLE `testmodel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
