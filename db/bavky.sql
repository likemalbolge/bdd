-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 13 2020 г., 23:20
-- Версия сервера: 10.4.10-MariaDB
-- Версия PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bavky`
--
CREATE DATABASE IF NOT EXISTS `bavky` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bavky`;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `game_id`, `user_id`, `comment_text`, `add_date`) VALUES
(1, 1, 1, 'pezda vashche', '2020-05-04 21:23:04'),
(2, 2, 1, 'mmmm toppp', '2020-05-04 21:28:39');

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` text NOT NULL,
  `resolution` varchar(20) NOT NULL,
  `img` text NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `developer` varchar(100) NOT NULL,
  `mobile_ready` varchar(10) NOT NULL DEFAULT 'ні',
  `add_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`id`, `title`, `link`, `resolution`, `img`, `description`, `tags`, `views`, `developer`, `mobile_ready`, `add_date`) VALUES
(1, 'Basket Random', '//html5.gamedistribution.com/rvvASMiM/bf1268dccb5d43e7970bb3edaa54afc8/?gd_zone_config=eyJwYXJlbnRVUkwiOiJodHRwczovL2h0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tL2JmMTI2OGRjY2I1ZDQzZTc5NzBiYjNlZGFhNTRhZmM4LyIsInBhcmVudERvbWFpbiI6Imh0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tIiwidG9wRG9tYWluIjoiaHRtbDUuZ2FtZWRpc3RyaWJ1dGlvbi5jb20iLCJoYXNJbXByZXNzaW9uIjpmYWxzZSwibG9hZGVyRW5hYmxlZCI6dHJ1ZSwidmVyc2lvbiI6IjEuMS4zNiJ9', '900,600', 'randombasket.png', 'Foso', 'Chotko, Zbs', 1, 'RHM Interactive', 'так', '2020-05-04'),
(2, 'Angry Owls', '//html5.gamedistribution.com/rvvASMiM/f48619c119224a83b8aa3a7fe1a4d682/?gd_zone_config=eyJwYXJlbnRVUkwiOiJodHRwczovL2h0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tL2Y0ODYxOWMxMTkyMjRhODNiOGFhM2E3ZmUxYTRkNjgyLyIsInBhcmVudERvbWFpbiI6Imh0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tIiwidG9wRG9tYWluIjoiaHRtbDUuZ2FtZWRpc3RyaWJ1dGlvbi5jb20iLCJoYXNJbXByZXNzaW9uIjpmYWxzZSwibG9hZGVyRW5hYmxlZCI6dHJ1ZSwidmVyc2lvbiI6IjEuMS4zNiJ9', '800,450', 'angryowls.png', 'Ahuet mozhna', 'Zbs, Nichose, Top', 4, 'Lof Games', 'так', '2020-05-04'),
(4, 'SILLY WAYS TO GET INFECTED', '//html5.gamedistribution.com/rvvASMiM/dee7173d2b55487a99bcc2ad079376b0/?gd_zone_config=eyJwYXJlbnRVUkwiOiJodHRwczovL2h0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tL2RlZTcxNzNkMmI1NTQ4N2E5OWJjYzJhZDA3OTM3NmIwLyIsInBhcmVudERvbWFpbiI6Imh0bWw1LmdhbWVkaXN0cmlidXRpb24uY29tIiwidG9wRG9tYWluIjoiaHRtbDUuZ2FtZWRpc3RyaWJ1dGlvbi5jb20iLCJoYXNJbXByZXNzaW9uIjpmYWxzZSwibG9hZGVyRW5hYmxlZCI6dHJ1ZSwidmVyc2lvbiI6IjEuMS4zNiJ9', '900,600', 'swtgi.png', 'Topchanskaya gejma', 'Top, Wow, Foso', 3, 'TinyDobbins', 'так', '2020-05-13');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `token` varchar(50) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'user',
  `last` text DEFAULT NULL,
  `join_date` date NOT NULL,
  `description` text NOT NULL DEFAULT 'Опис користувача',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `token`, `verified`, `type`, `last`, `join_date`, `description`) VALUES
(1, 'shipovnik', 'kokima5123@beiop.com', '$2y$10$tIQ0i4afKw35tKIEH9JmteI4bW20fzHItR6u38gqMSouDKlVTxeuq', '5ebc7effd41c4', 1, 'admin', '[\"2\",\"4\",\"1\"]', '2020-05-14', 'fosy poc');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
