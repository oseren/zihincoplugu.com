-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Haz 2024, 00:35:04
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `blog_web`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_body` longtext NOT NULL,
  `blog_image` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `commentActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `blog`
--

INSERT INTO `blog` (`blog_id`, `blog_title`, `blog_body`, `blog_image`, `category`, `author_id`, `views`, `likes`, `publish_date`, `active`, `commentActive`) VALUES
(109, 'Gündelik Demo 1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806002806_wallpaper.png', 34, 16, 0, 0, '2024-06-07 22:28:06', 1, 1),
(110, 'Gündelik Demo 2', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806002830_wallpaper.png', 34, 16, 0, 0, '2024-06-07 22:28:30', 1, 1),
(111, 'Keşif Demo 1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806002900_wallpaper.png', 35, 16, 0, 0, '2024-06-07 22:29:00', 1, 1),
(112, 'Keşif Demo 2', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806002914_wallpaper.png', 35, 16, 1, 0, '2024-06-07 22:29:14', 1, 1),
(113, 'Keşif Demo 3', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806003115_wallpaper.png', 35, 16, 0, 0, '2024-06-07 22:31:15', 1, 1),
(114, 'Keşif Demo 4', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', '20240806003235_wallpaper.png', 35, 16, 0, 0, '2024-06-07 22:32:35', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(34, 'Gündelik'),
(35, 'Keşif');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `content` text NOT NULL,
  `parentID` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `submitDate` datetime NOT NULL DEFAULT current_timestamp(),
  `adminComment` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `main`
--

CREATE TABLE `main` (
  `biography` text NOT NULL,
  `biographyname` varchar(30) NOT NULL DEFAULT 'Zeynep Berna YAMAN',
  `biographyimage` varchar(255) NOT NULL,
  `websitename` varchar(30) NOT NULL DEFAULT 'Zihin Çöplüğüm',
  `favicon` varchar(255) NOT NULL,
  `instagramlink` varchar(255) NOT NULL DEFAULT 'https://www.instagram.com',
  `twitterlink` varchar(255) NOT NULL DEFAULT 'https://twitter.com',
  `pinterestlink` varchar(255) NOT NULL DEFAULT 'https://tr.pinterest.com/',
  `questionText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `main`
--

INSERT INTO `main` (`biography`, `biographyname`, `biographyimage`, `websitename`, `favicon`, `instagramlink`, `twitterlink`, `pinterestlink`, `questionText`) VALUES
('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consequat facilisis lectus vel gravida. Donec eros dui, fringilla id malesuada ac, gravida eu tellus. Nunc sed orci eleifend, lobortis tortor ut, sollicitudin mi. Cras vitae ex rhoncus, hendrerit libero eu, ullamcorper elit. Pellentesque tortor velit, pulvinar eu ante a, aliquam volutpat eros. Quisque turpis purus, tempus at sapien eget, ornare malesuada orci. Donec vitae ante quis ligula porta fringilla. Suspendisse et congue nunc. Donec justo lectus, iaculis id euismod ut, dapibus ut massa. Duis faucibus sed lacus at luctus. Maecenas sit amet sapien vel risus vestibulum mattis vel vitae magna. Nullam dictum lacinia tortor ut luctus. Sed quis lacus eu nibh posuere eleifend eu et leo.</p>\r\n<p>Etiam eu odio sem. Donec fermentum, lectus a maximus ornare, odio mauris accumsan eros, nec faucibus libero neque nec ligula. Vestibulum a tortor dapibus, laoreet turpis eu, volutpat justo. Etiam non justo facilisis, tristique mi ut, pretium ante. Cras malesuada luctus euismod. Nulla erat sapien, lacinia vel velit in, laoreet porttitor mi. Ut euismod metus ac cursus euismod. Mauris tempus dolor sed pharetra egestas.</p>\r\n<p>Nullam purus leo, aliquam id convallis sed, efficitur nec dui. Suspendisse feugiat magna et malesuada accumsan. Vestibulum vitae facilisis erat, id laoreet nulla. Fusce porta suscipit sem, non varius velit maximus nec. Integer justo metus, placerat in urna in, consectetur congue velit. Sed a mauris vitae mi pellentesque aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque tristique dolor est, eu tincidunt lacus pretium sit amet. Aliquam vel egestas sapien. Sed ut libero in nibh maximus porttitor eu at massa. Curabitur quis mauris consequat, rutrum magna eu, interdum neque.</p>\r\n<p>Pellentesque laoreet, nulla ut dignissim vehicula, lorem mi rhoncus arcu, dictum varius enim tellus et orci. Donec blandit felis sodales, tincidunt neque et, tempor dolor. Suspendisse imperdiet velit eget pharetra sagittis. Sed efficitur facilisis nisi, at varius velit. Cras et sem dapibus, consectetur urna nec, tempus lorem. Donec eu turpis porta, porta orci a, auctor ligula. Mauris rhoncus erat vel leo pulvinar, ac malesuada eros mollis. Sed nibh elit, elementum a gravida a, bibendum id nisl. Maecenas vel mollis ipsum.</p>\r\n<p>Suspendisse hendrerit et augue eget laoreet. Curabitur lorem magna, aliquam at enim sed, malesuada pellentesque quam. Suspendisse potenti. Morbi felis erat, maximus et ultricies et, consequat id leo. Etiam sollicitudin aliquam accumsan. Sed et vestibulum erat, at consequat lorem. Nullam nec mi id lectus convallis convallis et in nisl. Fusce vel bibendum ligula, id maximus nibh. Donec vel leo justo. Donec commodo turpis at odio aliquam, sed hendrerit ante facilisis. Etiam dictum bibendum tempus. Nullam ac tellus in nibh suscipit tincidunt.</p>', 'Okan SEREN', '20240806003051_default_profile_photo.jpg', 'Zihin Çöplüğü', 'favicon.png', 'https://www.instagram.com', 'https://twitter.com', 'https://tr.pinterest.com', 'Merhabaa Ben Berna, soru sormak istediğinizde endişelenmeyin, bilgileriniz gizli kalacaktır. Ancak sorduğunuz soru herkesin görebileceği şekilde yayınlanacaktır. Çünkü biliyorum ki, bir sorunuz varsa muhtemelen birçok başka insanın da aynı soruyu sormak isteyeceği durumlar olabilir. Bu yüzden sorularınızı cesurca sorun, birlikte öğrenelim!');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `submitDate` datetime NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilephoto` varchar(255) NOT NULL DEFAULT 'default_profile_photo.jpg',
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `profilephoto`, `role`) VALUES
(16, 'Okan SEREN', 'okanseren64@gmail.com', 'e6fb45f87f4d6331f95dfe262dcb5c38fc6a760d', 'default_profile_photo.jpg', 1),
(22, 'Berna', 'yamanzeynepberna@gmail.com', 'be1873c2aa26a8efe0ac69e2793020a65c774bf4', 'default_profile_photo.jpg', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
