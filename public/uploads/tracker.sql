-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 01 2017 г., 17:36
-- Версия сервера: 5.6.17
-- Версия PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `tracker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `actions_method_key_unique` (`method_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `actions`
--

INSERT INTO `actions` (`id`, `method_key`, `name`, `created_at`, `updated_at`) VALUES
(1, 'give_group', 'Give group to any people', NULL, NULL),
(2, 'create_task', 'Create task', NULL, NULL),
(3, 'add_to_sprint', 'Add task to Sprint', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `action_group`
--

CREATE TABLE IF NOT EXISTS `action_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_method_action_id_foreign` (`action_id`),
  KEY `action_method_method_id_foreign` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `action_group`
--

INSERT INTO `action_group` (`id`, `action_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 2, 3, NULL, NULL),
(4, 3, 3, NULL, NULL),
(5, 2, 1, NULL, NULL),
(10, 3, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, NULL),
(2, 'User', NULL, NULL),
(3, 'PM', NULL, NULL),
(7, 'Test', NULL, '2017-01-23 11:44:08');

-- --------------------------------------------------------

--
-- Структура таблицы `group_method`
--

CREATE TABLE IF NOT EXISTS `group_method` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `method_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_method_group_id_foreign` (`group_id`),
  KEY `group_method_method_id_foreign` (`method_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `group_method`
--

INSERT INTO `group_method` (`id`, `group_id`, `method_id`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 3, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `group_user`
--

CREATE TABLE IF NOT EXISTS `group_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_user_group_id_foreign` (`group_id`),
  KEY `group_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Дамп данных таблицы `group_user`
--

INSERT INTO `group_user` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 3, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 2, 5, NULL, NULL),
(19, 1, 5, NULL, NULL),
(36, 1, 2, NULL, NULL),
(37, 2, 2, NULL, NULL),
(42, 1, 6, NULL, NULL),
(43, 3, 6, NULL, NULL),
(45, 1, 1, NULL, NULL),
(46, 2, 1, NULL, NULL),
(47, 7, 7, NULL, NULL),
(48, 2, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `summary` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `type_id` int(11) unsigned NOT NULL,
  `priority_id` int(11) NOT NULL,
  `reporter_id` int(11) unsigned NOT NULL,
  `assigned_id` int(11) unsigned NOT NULL,
  `original_estimate` int(10) unsigned NOT NULL,
  `remaining_estimate` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `project_id` (`project_id`),
  KEY `type_id` (`type_id`),
  KEY `priority_id` (`priority_id`),
  KEY `reporter_id` (`reporter_id`),
  KEY `assigned_id` (`assigned_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `issues`
--

INSERT INTO `issues` (`id`, `summary`, `description`, `status_id`, `project_id`, `type_id`, `priority_id`, `reporter_id`, `assigned_id`, `original_estimate`, `remaining_estimate`, `created_at`, `updated_at`) VALUES
(1, 'Create database tracker', 'Create new database tracker to view and bla-bla', 1, 2, 2, 1, 3, 4, 13455, 234, NULL, NULL),
(2, 'testing ', '', 2, 2, 2, 1, 4, 7, 1236, 24, '2017-01-28 06:11:05', '2017-01-28 06:59:51');

-- --------------------------------------------------------

--
-- Структура таблицы `issues_priorities`
--

CREATE TABLE IF NOT EXISTS `issues_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `issues_priorities`
--

INSERT INTO `issues_priorities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'minor', NULL, NULL),
(2, 'major', NULL, NULL),
(3, 'critical', NULL, NULL),
(4, 'blocker', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `issue_statuses`
--

CREATE TABLE IF NOT EXISTS `issue_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `issue_statuses`
--

INSERT INTO `issue_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'open', NULL, NULL),
(2, 'close', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `issue_types`
--

CREATE TABLE IF NOT EXISTS `issue_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `issue_types`
--

INSERT INTO `issue_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'task', '0000-00-00 00:00:00', NULL),
(2, 'story', '0000-00-00 00:00:00', NULL),
(3, 'bug', '0000-00-00 00:00:00', NULL),
(4, 'test1', '2017-01-25 12:22:14', '2017-01-25 12:22:20');

-- --------------------------------------------------------

--
-- Структура таблицы `methods`
--

CREATE TABLE IF NOT EXISTS `methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `methods`
--

INSERT INTO `methods` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admins', NULL, NULL),
(2, 'Users', NULL, NULL),
(3, 'PMs', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_12_26_143611_add_active_in_users_table', 1),
('2016_12_26_144043_create_groups_table', 1),
('2016_12_26_144732_create_group_user_table', 1),
('2017_01_05_102741_create_methods_table', 1),
('2017_01_08_120559_create_group_method_table', 1),
('2017_01_08_121217_create_actions_table', 1),
('2017_01_08_121656_create_action_method_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `name`, `key`, `created_at`, `updated_at`) VALUES
(1, 'conviction download method', 'CDM', NULL, NULL),
(2, 'proper daily tracker', 'PDT', NULL, NULL),
(6, 'test project', 'TP', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `project_user`
--

CREATE TABLE IF NOT EXISTS `project_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(3, 2, 6, NULL, NULL),
(4, 2, 5, NULL, NULL),
(5, 1, 8, NULL, NULL),
(6, 2, 8, NULL, NULL),
(7, 1, 1, NULL, NULL),
(8, 2, 1, NULL, NULL),
(9, 2, 9, NULL, NULL),
(12, 6, 4, NULL, NULL),
(13, 6, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sprints`
--

CREATE TABLE IF NOT EXISTS `sprints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date_start` timestamp NOT NULL,
  `date_finish` timestamp NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `sprints`
--

INSERT INTO `sprints` (`id`, `name`, `description`, `date_start`, `date_finish`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'create database', 'Add in MySQL database with name tracker', '2017-01-29 05:51:06', '2017-02-28 05:00:00', 2, NULL, NULL),
(3, 'test', 'testing store method', '2017-01-11 23:03:00', '2017-01-11 23:03:00', 2, '2017-01-29 06:33:09', '2017-01-29 06:33:09'),
(4, 'test', 'testing store method', '2017-01-11 23:03:00', '2017-01-11 23:03:00', 2, '2017-01-29 06:34:10', '2017-01-29 06:34:10'),
(5, 'test4', 'It''s work perfectly', '2017-02-20 05:00:00', '2017-02-26 05:00:00', 2, '2017-01-29 06:35:21', '2017-01-29 07:09:41');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `active`) VALUES
(1, 'Tipical User', 'user@example.com', '$2y$10$ZEhKbUCdG8aIjKzCr/lr7Oy0JVu8KoJGmimDWp3I2cPnJ9mHpg3F.', '4BuaSp8RtbnYmebnw1x6xsuRoE80pbSi1lNlsw5KXPSEKNm8wjMrGAMwv2T3', '2017-01-08 09:34:32', '2017-01-28 12:42:52', 1),
(2, 'Older Freid', 'admin@example.ua', '$2y$10$x0Hh7ynuNUMC5LQPjTHO9ukhfDWNuFAHx6nab3OnFNgTHVYkiRZNy', 'MRbDjjsCgxSiOzbGJAWCjSlefLXIP613aocjjdfL257AUJiG8W7opOde4syp', '2017-01-10 12:36:42', '2017-01-21 09:16:31', 1),
(3, 'Daren Hase', 'daren@gmail.com', '$2y$10$39MsntK1v.Hb0uez4rpx1.7zLqKyHPDoO8nAuGQV7iX99hmM1buxa', 'WrmoFp9irAhDcvtwPdmiPuQuby5DDGr66uCnLeMjKleTPGqPIeTz3LtC0MF0', '2017-01-10 12:42:19', '2017-01-19 09:30:11', 1),
(4, 'Rene Fishman', 'rene@example.com', '$2y$10$p8g5px66sYw/eEoCLKEZJuVAhyzFwjrDryQQdgSI8ClOpLGGaMO0a', 'z8nyoNwceooBBY08pEI1KIIHTjSPEhPufJXAGHuTHvhvZWBgTiL7nLSn18no', '2017-01-14 05:02:39', '2017-01-22 08:41:52', 1),
(5, 'Tony Marshvec', 'tony@example.ua', '$2y$10$Fy3y5VBu6J2TR7eonn34P.QC4TClwPbbGHq.3GtkU9hSv7J7CAqwG', NULL, '2017-01-15 07:34:12', '2017-01-21 05:58:11', 0),
(6, 'Nano Igliani', 'nano@example.com', '$2y$10$PDtmpEpiKLzSGU4BdgW25.HT2q76AiB/sOPfW4CtriN7gMb9H2/pm', NULL, '2017-01-19 09:27:56', '2017-01-19 09:27:56', 1),
(7, 'Niko Alber', 'niko@example.com', '$2y$10$ZP.Insf1W9teLBYgzunoNuYMUhZME6dwYKsYCOeadaZ/BpwVA/EP.', NULL, '2017-01-21 09:52:06', '2017-01-21 09:52:06', 0),
(8, 'Test User', 'test@example.com', '$2y$10$MK6OW1xNVJTpQz7uernSYuKNYS03tyK8rVz.5vL7xzE1ynPEkwtYO', NULL, NULL, NULL, 0),
(9, 'AnotherOne User', 'another@example.com', '$2y$10$.lpZOSF/q/S3spfSXw7lCuYIBQoxOC/pPK3dudUdzoRc9bHqe6yca', NULL, NULL, NULL, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `action_group`
--
ALTER TABLE `action_group`
  ADD CONSTRAINT `action_method_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `action_method_method_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_method`
--
ALTER TABLE `group_method`
  ADD CONSTRAINT `group_method_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_method_method_id_foreign` FOREIGN KEY (`method_id`) REFERENCES `methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `issue_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_3` FOREIGN KEY (`priority_id`) REFERENCES `issues_priorities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `issue_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_5` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_6` FOREIGN KEY (`assigned_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `project_user_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sprints`
--
ALTER TABLE `sprints`
  ADD CONSTRAINT `sprints_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
