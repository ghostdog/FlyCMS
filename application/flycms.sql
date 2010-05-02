-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 02 Maj 2010, 04:06
-- Wersja serwera: 5.1.41
-- Wersja PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `flycms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `menugroups`
--

CREATE TABLE IF NOT EXISTS `menugroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` tinyint(4) NOT NULL,
  `is_global` tinyint(4) NOT NULL DEFAULT '1',
  `order` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `menugroups`
--

INSERT INTO `menugroups` (`id`, `name`, `location`, `is_global`, `order`, `created`) VALUES
(1, 'Ptaki', 0, 1, 0, 0),
(2, 'Zwierzęta', 1, 1, 0, 0),
(7, 'Ryby', 2, 1, 1, 1),
(8, 'dasasdasdas', 2, 1, 0, 1272661966);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `menuitems`
--

CREATE TABLE IF NOT EXISTS `menuitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `order` tinyint(4) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `menuitems`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `pagemenu`
--

CREATE TABLE IF NOT EXISTS `pagemenu` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `menugroup_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`,`menugroup_id`),
  KEY `menugroup_id` (`menugroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pagemenu`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `keywords` tinytext,
  `description` tinytext,
  `template_id` int(11) unsigned DEFAULT NULL,
  `header_on` tinyint(4) DEFAULT NULL,
  `footer_on` int(11) DEFAULT NULL,
  `sidebar_on` int(11) DEFAULT NULL,
  `content` longblob NOT NULL,
  `created` int(11) NOT NULL,
  `last_modified` int(11) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`,`link`),
  UNIQUE KEY `link` (`link`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=162 ;

--
-- Zrzut danych tabeli `pages`
--

INSERT INTO `pages` (`id`, `title`, `link`, `keywords`, `description`, `template_id`, `header_on`, `footer_on`, `sidebar_on`, `content`, `created`, `last_modified`, `author`) VALUES
(14, 'Strona 10', 'strona-10', NULL, NULL, NULL, NULL, NULL, NULL, 0x546f206a657374206a616b61c59b207a61776172746fc59bc487207374726f6e79, 1271897616, 1271907116, NULL),
(138, 'Strona 14', 'strona-14', NULL, NULL, NULL, NULL, NULL, NULL, 0x546f206a657374206a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272226310, NULL, NULL),
(139, 'Strona 15', 'strona-15', NULL, NULL, NULL, NULL, NULL, NULL, 0x546f206a657374206a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272226311, 1272363744, NULL),
(140, 'Strona 16', 'strona-16', NULL, NULL, NULL, NULL, NULL, NULL, 0x546f206a657374206a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272226312, NULL, NULL),
(141, 'Strona 17', 'strona-17', NULL, NULL, NULL, NULL, NULL, NULL, 0x546f206a657374206a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272226313, NULL, NULL),
(145, 'Strona 100', 'strona-100', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277567, NULL, NULL),
(149, 'Strona 104', 'strona-104', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277571, NULL, NULL),
(150, 'Strona 105', 'strona-105', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277572, NULL, NULL),
(151, 'Strona 106', 'strona-106', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277573, NULL, NULL),
(152, 'Strona 107', 'strona-107', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277574, NULL, NULL),
(153, 'Strona 108', 'strona-108', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277574, NULL, NULL),
(157, 'Strona 112', 'strona-112', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277583, NULL, NULL),
(158, 'Strona 113', 'strona-113', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277584, NULL, NULL),
(159, 'Strona 114', 'strona-114', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277585, NULL, NULL),
(160, 'Strona 115', 'strona-115', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277585, NULL, NULL),
(161, 'Strona 116', 'strona-116', NULL, NULL, NULL, NULL, NULL, NULL, 0x4a616b61c59b2074616d207a61776172746fc59bc487207374726f6e79, 1272277586, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(50) NOT NULL,
  `template_id` int(10) unsigned DEFAULT NULL,
  `header_on` tinyint(4) NOT NULL DEFAULT '1',
  `footer_on` tinyint(4) NOT NULL DEFAULT '1',
  `sidebar_on` tinyint(4) NOT NULL DEFAULT '1',
  `keywords` tinytext,
  `description` tinytext,
  `author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`id`, `title`, `subtitle`, `template_id`, `header_on`, `footer_on`, `sidebar_on`, `keywords`, `description`, `author`) VALUES
(2, 'To jest moja nazwa strony', 'Kilka słów o mojej stronie', 57, 1, 1, 1, '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` tinytext,
  `has_img` tinyint(4) DEFAULT '0',
  `is_global` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Zrzut danych tabeli `templates`
--

INSERT INTO `templates` (`id`, `name`, `description`, `has_img`, `is_global`, `created`) VALUES
(57, 'Orange', '', 1, 1, 1271705842);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `menugroups` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `pagemenu`
--
ALTER TABLE `pagemenu`
  ADD CONSTRAINT `pagemenu_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagemenu_ibfk_2` FOREIGN KEY (`menugroup_id`) REFERENCES `menugroups` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`);

--
-- Ograniczenia dla tabeli `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
