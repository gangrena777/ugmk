-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 11 2023 г., 21:35
-- Версия сервера: 5.7.35-38
-- Версия PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cr45681_yii`
--
CREATE DATABASE IF NOT EXISTS `cr45681_yii` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cr45681_yii`;

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `population` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

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
-- Структура таблицы `object`
--

CREATE TABLE IF NOT EXISTS `object` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `addres` varchar(255) NOT NULL,
  `communications` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `photo_ids` varchar(255) NOT NULL,
  `doc_ids` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `object`
--

INSERT INTO `object` (`id`, `name`, `addres`, `communications`, `description`, `info`, `photo_ids`, `doc_ids`) VALUES
(2, 'Березовский Гагарина 17', 'г.Березовский Гагарина 17 - 17,21,27,29', '6666-88866', 'Пожарка на Болид\r\n', '4 с2000м\n4БИ\n17 приборы на этажах\n21,27,29 в электрощитовых\nqwerty qwerty qwerty\nqazqazqaz wsxwsx\nzxcvbnm zxcvbnm\n##############################\nВввввввввввв иииииииии йййййй\nгагарина 29  — 4подьезд  4 эл.щит   с2000сп1 адр.45  1 реле  —- открытие ворот (сигнал на оба шкафа шлагбаума)\n\n\r\nкартинка_1678299661-file_35.jpg\r\nДобавляю данные к объекту №2.', ',1678299661-file_35.jpg', ''),
(4, 'Даниловский 2', 'Данилы Зверева 11', 'Андрей 950-644-24-20\r\nохрана 8982-658-08-86', 'пожарка рубеж\r\nдомофония Came Xip bpt\r\nвидео ', '\r\nдокумент_БВД-343x_O2_ru_20200907_A4.pdf\r\nдокумент_terms_of_use.pdf\r\nкартинка_1693687441-file_208.jpg', ',1693687441-file_208.jpg', ',Паспорт БК-A418.pdf,БВД-343x_O2_ru_20200907_A4.pdf,terms_of_use.pdf'),
(5, 'qwerttttttty', 'ул.березовский ул.гагарина 27', '000-000-000', 'qazwsxedc bgy _iu87gh', '\r\nдокумент_google_terms_of_service_ru.pdf\r\nдокумент_1622.pdf\r\nдокумент_agreement.pdf\r\nдокумент_A_B460.pdf\r\nкартинка_1693687445-file_209.jpg', '1677963544-file_11.jpg,1677963841-file_12.jpg,1692283724-file_170.jpg,1693471416-file_192.jpg,1693678307-file_199.jpg,1693687445-file_209.jpg', ',google_terms_of_service_ru.pdf,1622.pdf,agreement.pdf,A_B460.pdf'),
(7, 'Мередиан', 'Совкова 35/2', 'Алексей лифтер 89049803882', 'ЖК 5 подъездов.  Апс видео шлакдаум', 'Видео \nРегистратор tantos 192.168.2.100\nAdmin qwerty0909\nАпс рубеж \nв лифтах  точки доступа :  tp-link cpe 210   ssid  4sGL    admin pharos      ubiqunty  ubnt pharos\nкартинка_1687763946-file_127.jpg\nЛокальная сеть собрана последовательным соединением коммутаторов между собой\r\nШкафы со свитчами находятся 1-й под 5-м домом, 2-й под 4-м домом, 3-й под 3-м, под 2-м домом и все это сводится в свитч на посту охраны под 1-м домом.\r\n\r\n\r\nкартинка_1693575354-file_198.jpg\r\nдокумент_1622.pdf\r\nкартинка_1693687454-file_210.jpg\r\nкартинка_1693687458-file_211.jpg\r\nкартинка_1693687462-file_212.jpg', ',1687763946-file_127.jpg,1693575354-file_198.jpg,1693687454-file_210.jpg,1693687458-file_211.jpg,1693687462-file_212.jpg', ',1622.pdf');

-- --------------------------------------------------------

--
-- Структура таблицы `telegrambot`
--

CREATE TABLE IF NOT EXISTS `telegrambot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `update_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `qwestion_data` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `telegrambot`
--

INSERT INTO `telegrambot` (`id`, `user_id`, `chat_id`, `message_id`, `update_id`, `object_id`, `qwestion_data`) VALUES
(26, 815668656, 815668656, 787, 0, 0, '0'),
(47, 815668656, 815668656, 892, 0, 0, '0'),
(58, 815668656, 815668656, 943, 529252138, 0, '0'),
(59, 815668656, 815668656, 943, 529252140, 0, '0'),
(73, 815668656, 815668656, 1035, 529252210, 5, '0'),
(74, 815668656, 815668656, 1055, 529252214, 4, 'add_to_info_field'),
(75, 815668656, 815668656, 1055, 529252217, 4, 'add_to_info_field'),
(76, 815668656, 815668656, 1064, 529252222, 6, 'add_to_info_field'),
(77, 815668656, 815668656, 1069, 529252226, 5, 'add_to_info_field'),
(78, 815668656, 815668656, 1074, 529252230, 2, 'add_to_info_field'),
(79, 815668656, 815668656, 1074, 529252232, 2, '0'),
(80, 815668656, 815668656, 1074, 529252234, 2, '0'),
(81, 815668656, 815668656, 1083, 529252237, 5, 'add_to_info_field'),
(82, 815668656, 815668656, 1091, 529252242, 6, '0'),
(83, 815668656, 815668656, 1097, 529252246, 5, '0'),
(84, 815668656, 815668656, 1105, 529252252, 5, '0'),
(85, 815668656, 815668656, 1109, 529252255, 6, '0'),
(86, 815668656, 815668656, 1115, 529252259, 4, '0'),
(87, 815668656, 815668656, 1130, 529252271, 2, '0'),
(88, 815668656, 815668656, 1264, 529252460, 4, '0'),
(89, 815668656, 815668656, 1282, 529252482, 4, '0'),
(90, 815668656, 815668656, 1289, 529252488, 5, '0'),
(91, 815668656, 815668656, 1295, 529252492, 6, 'add_to_info_field'),
(92, 815668656, 815668656, 1300, 529252496, 6, '0'),
(93, 815668656, 815668656, 1300, 529252498, 6, '0'),
(94, 815668656, 815668656, 1309, 529252502, 5, '0'),
(95, 815668656, 815668656, 1309, 529252504, 5, '0'),
(96, 815668656, 815668656, 1320, 529252509, 2, '0'),
(97, 815668656, 815668656, 1326, 529252513, 2, '0'),
(98, 815668656, 815668656, 1332, 529252517, 2, '0'),
(99, 815668656, 815668656, 1339, 529252526, 6, 'add_to_info_field'),
(100, 815668656, 815668656, 1386, 529252578, 6, '0'),
(101, 815668656, 815668656, 1398, 529252588, 2, '0'),
(102, 815668656, 815668656, 1404, 529252592, 4, '0'),
(103, 815668656, 815668656, 1413, 529252599, 5, '0'),
(104, 815668656, 815668656, 1422, 529252605, 4, '0'),
(105, 815668656, 815668656, 1426, 529252607, 4, 'add_to_info_field'),
(106, 815668656, 815668656, 1429, 529252610, 5, '0'),
(107, 815668656, 815668656, 1433, 529252612, 5, '0'),
(108, 815668656, 815668656, 1437, 529252614, 5, '0'),
(109, 815668656, 815668656, 1441, 529252617, 5, 'add_to_info_field'),
(110, 815668656, 815668656, 1445, 529252620, 6, '0'),
(111, 815668656, 815668656, 1449, 529252622, 6, '0'),
(112, 815668656, 815668656, 1453, 529252626, 5, '0'),
(113, 815668656, 815668656, 1457, 529252630, 6, '0'),
(114, 815668656, 815668656, 1461, 529252634, 5, '0'),
(115, 815668656, 815668656, 1465, 529252638, 5, 'add_to_info_field'),
(116, 815668656, 815668656, 1465, 529252639, 5, 'add_to_info_field'),
(117, 815668656, 815668656, 1469, 529252642, 6, '0'),
(118, 815668656, 815668656, 1469, 529252644, 6, '0'),
(119, 815668656, 815668656, 1475, 529252648, 5, '0'),
(120, 815668656, 815668656, 1479, 529252652, 5, '0'),
(121, 815668656, 815668656, 1479, 529252654, 5, '0'),
(122, 815668656, 815668656, 1485, 529252656, 6, 'add_to_info_field'),
(123, 815668656, 815668656, 1501, 529252657, 5, '0'),
(124, 815668656, 815668656, 1507, 529252661, 5, '0'),
(125, 815668656, 815668656, 1512, 529252663, 5, '0'),
(126, 815668656, 815668656, 1517, 529252665, 5, '0'),
(127, 815668656, 815668656, 1522, 529252667, 5, '0'),
(128, 815668656, 815668656, 1527, 529252669, 5, '0'),
(129, 815668656, 815668656, 1532, 529252671, 5, '0'),
(130, 815668656, 815668656, 1540, 529252676, 5, '0'),
(131, 815668656, 815668656, 1544, 529252678, 5, 'add_to_info_field'),
(132, 815668656, 815668656, 1544, 529252679, 5, 'add_to_info_field'),
(133, 815668656, 815668656, 1550, 529252684, 6, '0'),
(134, 815668656, 815668656, 1560, 529252693, 5, '0'),
(135, 815668656, 815668656, 1567, 529252697, 5, '0'),
(136, 815668656, 815668656, 1576, 529252703, 5, '0'),
(137, 815668656, 815668656, 1582, 529252707, 5, '0'),
(138, 815668656, 815668656, 1589, 529252711, 5, '0'),
(139, 815668656, 815668656, 1596, 529252715, 5, '0'),
(140, 815668656, 815668656, 1609, 529252717, 5, '0'),
(141, 815668656, 815668656, 1625, 529252721, 2, '0'),
(142, 815668656, 815668656, 1629, 529252723, 2, '0'),
(143, 815668656, 815668656, 1641, 529252730, 6, '0'),
(144, 815668656, 815668656, 1646, 529252732, 6, '0'),
(145, 815668656, 815668656, 1655, 529252736, 6, '0'),
(146, 815668656, 815668656, 1667, 529252742, 2, '0'),
(147, 815668656, 815668656, 1689, 529252758, 5, '0'),
(148, 815668656, 815668656, 1725, 529252776, 2, '0'),
(149, 815668656, 815668656, 1778, 529252794, 2, '0'),
(150, 815668656, 815668656, 1778, 529252796, 2, '0'),
(151, 815668656, 815668656, 1803, 529252800, 6, '0'),
(152, 815668656, 815668656, 1819, 529252804, 2, '0'),
(153, 815668656, 815668656, 1837, 529252808, 6, '0'),
(154, 815668656, 815668656, 1855, 529252812, 6, '0'),
(155, 815668656, 815668656, 1875, 529252816, 6, '0'),
(156, 815668656, 815668656, 1897, 529252820, 6, '0'),
(157, 815668656, 815668656, 1957, 529252834, 6, '0'),
(158, 815668656, 815668656, 1978, 529252842, 2, '0'),
(159, 815668656, 815668656, 2025, 529252863, 5, '0'),
(160, 815668656, 815668656, 2085, 529252899, 4, 'add_to_info_field'),
(161, 815668656, 815668656, 2166, 529252929, 4, 'add_to_info_field'),
(162, 815668656, 815668656, 2166, 529252930, 4, '0'),
(163, 815668656, 815668656, 2172, 529252934, 4, '0'),
(164, 815668656, 815668656, 2292, 529252983, 7, '0'),
(165, 815668656, 815668656, 2380, 529253043, 7, '0'),
(166, 815668656, 815668656, 2388, 529253046, 7, 'add_to_info_field'),
(167, 815668656, 815668656, 2610, 529253106, 5, '0'),
(168, 815668656, 815668656, 2625, 529253110, 5, '0'),
(169, 815668656, 815668656, 2645, 529253117, 5, 'add_to_info_field'),
(170, 815668656, 815668656, 2653, 529253121, 5, '0'),
(171, 815668656, 815668656, 2664, 529253125, 4, '0'),
(172, 815668656, 815668656, 2748, 529253163, 5, '0'),
(173, 815668656, 815668656, 2756, 529253166, 5, '0'),
(174, 815668656, 815668656, 2767, 529253168, 5, '0'),
(175, 815668656, 815668656, 2784, 529253173, 5, '0'),
(176, 815668656, 815668656, 2798, 529253177, 4, '0'),
(177, 815668656, 815668656, 2809, 529253181, 2, '0'),
(178, 815668656, 815668656, 2824, 529253187, 7, '0'),
(179, 815668656, 815668656, 2832, 529253189, 7, '0'),
(180, 815668656, 815668656, 2840, 529253191, 7, '0'),
(181, 815668656, 815668656, 2846, 529253193, 7, '0'),
(182, 815668656, 815668656, 2854, 529253197, 7, '0'),
(183, 815668656, 815668656, 2863, 529253200, 7, 'add_to_info_field'),
(184, 815668656, 815668656, 2871, 529253203, 5, 'add_to_info_field'),
(185, 815668656, 815668656, 2871, 529253204, 5, '0'),
(186, 815668656, 815668656, 2883, 529253209, 5, '0'),
(187, 815668656, 815668656, 2893, 529253212, 5, '0'),
(188, 815668656, 815668656, 2903, 529253214, 5, '0'),
(189, 815668656, 815668656, 2913, 529253217, 5, '0'),
(190, 815668656, 815668656, 2923, 529253220, 5, '0'),
(191, 815668656, 815668656, 2932, 529253222, 5, '0'),
(192, 815668656, 815668656, 2944, 529253225, 5, '0'),
(193, 815668656, 815668656, 2954, 529253227, 5, '0'),
(194, 815668656, 815668656, 2964, 529253229, 5, '0'),
(195, 815668656, 815668656, 2990, 529253237, 4, '0'),
(196, 815668656, 815668656, 2996, 529253239, 4, '0'),
(197, 815668656, 815668656, 3014, 529253246, 5, '0'),
(198, 815668656, 815668656, 3025, 529253248, 5, '0'),
(199, 815668656, 815668656, 3036, 529253250, 5, '0'),
(200, 815668656, 815668656, 3058, 529253256, 4, '0'),
(201, 815668656, 815668656, 3079, 529253263, 7, '0'),
(202, 815668656, 815668656, 3096, 529253267, 5, 'add_to_info_field'),
(203, 815668656, 815668656, 3096, 529253268, 5, '0'),
(204, 815668656, 815668656, 3118, 529253272, 4, '0'),
(205, 815668656, 815668656, 3132, 529253276, 5, '0'),
(206, 815668656, 815668656, 3157, 529253283, 7, '0'),
(207, 815668656, 815668656, 3165, 529253287, 7, '0'),
(208, 815668656, 815668656, 3173, 529253291, 7, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `testmodel`
--

CREATE TABLE IF NOT EXISTS `testmodel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `testmodel`
--

INSERT INTO `testmodel` (`id`, `name`, `description`, `text`) VALUES
(1, 'name_2', '333wwwe3333', '334de44444'),
(2, 'name_3333', '333wwwe3333', '334de44444');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
