-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 23 2013 г., 19:33
-- Версия сервера: 5.5.28
-- Версия PHP: 5.3.20

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `rstrip`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `id_ll_name` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `id_ll_name` (`id_ll_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `url`, `id_ll_name`, `deleted`) VALUES
(1, 'russia', 2, 0),
(2, 'saint-petersburg', 3, 0),
(3, 'italy', 4, 0),
(4, 'rome', 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `category_category`
--

CREATE TABLE IF NOT EXISTS `category_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_child` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_child` (`id_child`),
  KEY `id_parent` (`id_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `category_category`
--

INSERT INTO `category_category` (`id`, `id_child`, `id_parent`) VALUES
(1, 2, 1),
(2, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbrev` varchar(3) NOT NULL,
  `id_ll_name` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbrev` (`abbrev`),
  KEY `id_ll_name` (`id_ll_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `language`
--

INSERT INTO `language` (`id`, `abbrev`, `id_ll_name`) VALUES
(1, 'ru', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `language_label`
--

CREATE TABLE IF NOT EXISTS `language_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `language_label`
--

INSERT INTO `language_label` (`id`) VALUES
(1),
(2),
(3),
(4),
(5);

-- --------------------------------------------------------

--
-- Структура таблицы `language_text`
--

CREATE TABLE IF NOT EXISTS `language_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_label` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_label` (`id_label`,`id_language`),
  KEY `id_language` (`id_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `language_text`
--

INSERT INTO `language_text` (`id`, `id_label`, `id_language`, `text`) VALUES
(1, 1, 1, 'Русский'),
(2, 2, 1, 'Россия'),
(3, 3, 1, 'Санкт-Петербург'),
(4, 4, 1, 'Италия'),
(5, 5, 1, 'Рим');

-- --------------------------------------------------------

--
-- Структура таблицы `poi`
--

CREATE TABLE IF NOT EXISTS `poi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `id_user` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `have_excursions` tinyint(1) DEFAULT NULL,
  `visit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `poi`
--

INSERT INTO `poi` (`id`, `latitude`, `longitude`, `id_user`, `creation_date`, `update_date`, `img`, `have_excursions`, `visit_time`) VALUES
(6, 59.904, 30.357, 1, '2013-05-11 12:08:44', '2013-05-11 16:19:07', '/img/poi/1.jpg', NULL, NULL),
(7, 59.9209, 30.387, 1, '2013-05-11 12:09:24', '2013-05-11 16:18:39', '/img/poi/2.jpg', NULL, NULL),
(8, 59.946, 30.25, 1, '2013-05-11 12:09:54', '2013-05-11 16:19:11', '/img/poi/3.jpg', NULL, NULL),
(19, 59.927151604123, 30.317802429199, 1, '2013-05-11 17:08:00', '2013-06-23 19:30:10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `poi_localized`
--

CREATE TABLE IF NOT EXISTS `poi_localized` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_poi` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `motivation` text,
  `schedule` text,
  `price` text,
  `features` text,
  `parking` text,
  `food` text,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_poi` (`id_poi`,`id_language`),
  KEY `id_language` (`id_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `poi_localized`
--

INSERT INTO `poi_localized` (`id`, `id_poi`, `id_language`, `name`, `description`, `motivation`, `schedule`, `price`, `features`, `parking`, `food`, `website`) VALUES
(1, 6, 1, 'Литераторские мостки', 'Литераторские мостки — мемориальное кладбище Санкт-Петербурга, часть Волковского кладбища. Здесь захоронены известные писатели, актёры, учёные, политики и другие известные люди.', NULL, 'Часы работы: с ноября по март — 11:00-17:00, в летний период — 11:00-19:00; выходной — четверг', 'бесплатно', NULL, NULL, NULL, 'litmostki.ru'),
(2, 7, 1, 'Александро-Невская лавра', 'На территории Свято-Троицкая Александро-Невская лавры работает музей городской скульптуры - Некрополь XVIII века и Некрополь Мастеров искусств.', NULL, 'Часы работы: ежедневно с 10:00 до 17:30, касса работает до 17:00', '150 рублей', NULL, NULL, NULL, 'lavra.spb.ru'),
(3, 8, 1, 'Смоленское кладбище', 'Смоленское лютеранское кладбище (стар. Немецкое кладбище) — старейшее из неправославных (1747), лютеранское кладбище в Санкт-Петербурге.', NULL, 'Часы работы: Октябрь – Апрель 9:00 - 17:00; Май – Сентябрь 9:00 - 18:00; выходной: 1 Января.', 'бесплатно', NULL, NULL, NULL, 'smolenskoe.com'),
(14, 19, 1, 'Садовая', 'метро Садовая', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity_ts` int(11) NOT NULL,
  `session` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Дамп данных таблицы `session`
--

INSERT INTO `session` (`id`, `code`, `creation_time`, `last_activity_ts`, `session`) VALUES
(78, 'c14018881effec2f078406cae29fbcf9', '2013-06-23 08:44:52', 1372001391, 'a:3:{s:12:"map_latitude";s:6:"59.896";s:13:"map_longitude";s:6:"30.318";s:8:"map_zoom";s:2:"12";}');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `description`, `details`) VALUES
(1, 'site_title', 'ReadySteadyTrip.ru', 'Название сайта', 'Отображается как название вкладки браузера');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`) VALUES
(1, 'alla');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`id_ll_name`) REFERENCES `language_label` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category_category`
--
ALTER TABLE `category_category`
  ADD CONSTRAINT `category_category_ibfk_1` FOREIGN KEY (`id_child`) REFERENCES `category` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `category_category_ibfk_2` FOREIGN KEY (`id_parent`) REFERENCES `category` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `language_ibfk_1` FOREIGN KEY (`id_ll_name`) REFERENCES `language_label` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `language_text`
--
ALTER TABLE `language_text`
  ADD CONSTRAINT `language_text_ibfk_1` FOREIGN KEY (`id_label`) REFERENCES `language_label` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `language_text_ibfk_2` FOREIGN KEY (`id_language`) REFERENCES `language` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poi`
--
ALTER TABLE `poi`
  ADD CONSTRAINT `poi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poi_localized`
--
ALTER TABLE `poi_localized`
  ADD CONSTRAINT `poi_localized_ibfk_1` FOREIGN KEY (`id_poi`) REFERENCES `poi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `poi_localized_ibfk_2` FOREIGN KEY (`id_language`) REFERENCES `language` (`id`) ON UPDATE CASCADE;
