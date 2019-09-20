-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: St 11.Nov 2015, 13:42
-- Verzia serveru: 5.6.21
-- Verzia PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `kniznica`
--

--
-- Sťahujem dáta pre tabuľku `address`
--

INSERT INTO `address` (`id`, `address`, `street`, `street_number`, `zip`, `city_id`, `updated_at`, `created_at`) VALUES
(1, 'XZ Central s.r.o', 'Einsteinova', '99', '85101', 1, NULL, '2015-07-20 19:49:42');

--
-- Sťahujem dáta pre tabuľku `author`
--

INSERT INTO `author` (`id`, `first_name`, `last_name`, `updated_at`, `created_at`) VALUES
(10, 'Janko', 'Hrasko', NULL, '2015-07-20 20:47:08'),
(11, 'Čeman', 'Róbert', NULL, '2015-07-21 09:56:29'),
(13, 'Zandl', 'Patrick', NULL, '2015-07-21 10:12:55');

--
-- Sťahujem dáta pre tabuľku `book`
--

INSERT INTO `book` (`id`, `internal_id`, `name`, `page_count`, `isbn`, `issn`, `language_id`, `library_id`, `publisher_id`, `type_id`, `status_id`, `category_id`, `edition`, `description`, `updated_at`, `created_at`) VALUES
(8, '00000000008', 'PHP 6 : začínáme programovat', 183, '978-80-247-3899-4', '', 1, 1, 1, 2, 1, 2, 1, '', '2015-07-21 09:50:16', '2015-07-20 19:49:41'),
(10, '00000000010', 'Rekordy: Neživá príroda ( Geografická encyklopédia )', 192, '', '', 1, 2, 1, 1, 5, 1, NULL, '', '2015-08-20 12:20:29', '2015-07-21 09:56:29'),
(13, '00000000013', 'Apple: Cesta k mobilum', 272, '', '', 2, 3, 3, 1, 1, 1, 1, 'Kniha se zaobírá přelomovými technologiemi, se kterými Apple přišel na trh. Dívá se do pozadí, proč vznikly, jak vznikly a jak ovlivnily trh. Oproti jiným podobným textům zasazuje události do kontextu, tedy ukazuje, jak na jednotlivé produkty reagoval trh', '2015-11-11 12:00:44', '2015-07-21 10:12:55');

--
-- Sťahujem dáta pre tabuľku `book_author`
--

INSERT INTO `book_author` (`book_id`, `author_id`, `created_at`) VALUES
(8, 10, '2015-07-20 20:47:09'),
(10, 11, '2015-07-21 09:56:29'),
(13, 13, '2015-07-21 10:12:55');

--
-- Sťahujem dáta pre tabuľku `book_key_word`
--

INSERT INTO `book_key_word` (`book_id`, `key_word_id`, `created_at`) VALUES
(8, 14, '2015-07-20 19:49:45'),
(8, 15, '2015-07-20 19:49:45'),
(10, 21, '2015-07-21 09:56:29'),
(13, 29, '2015-11-11 12:00:44');

--
-- Sťahujem dáta pre tabuľku `category`
--

INSERT INTO `category` (`id`, `category_name`, `updated_at`, `created_at`) VALUES
(1, 'Odborná a technická literatúra', '2015-11-11 12:00:21', '2015-07-20 19:49:42'),
(2, 'Motivačné', '2015-07-19 19:11:26', '2015-07-20 19:49:42'),
(3, 'Psychológia', '2015-07-19 19:12:33', '2015-07-20 19:49:42'),
(4, 'Rodina, životný štýl, krása', '2015-07-19 19:12:33', '2015-07-20 19:49:42'),
(5, 'Sci-fi, fantasy', '2015-07-19 19:13:45', '2015-07-20 19:49:42'),
(6, 'Ekonomika, Právo, Manažment', '2015-07-19 19:13:45', '2015-07-20 19:49:42'),
(8, 'Dobrodružné', '2015-07-20 20:36:14', '2015-07-20 19:49:42');

--
-- Sťahujem dáta pre tabuľku `city`
--

INSERT INTO `city` (`id`, `city`, `country_id`, `created_at`) VALUES
(1, 'Bratislava', 1, '2015-07-20 19:49:44');

--
-- Sťahujem dáta pre tabuľku `country`
--

INSERT INTO `country` (`id`, `country`, `created_at`) VALUES
(1, 'Slovenská republika', '2015-07-20 19:49:44');

--
-- Sťahujem dáta pre tabuľku `key_word`
--

INSERT INTO `key_word` (`id`, `word`, `updated_at`, `created_at`) VALUES
(14, 'php', '2015-06-03 11:35:41', '2015-07-20 19:49:45'),
(15, 'programovanie', '2015-06-03 11:35:41', '2015-07-20 19:49:45'),
(21, '', NULL, '2015-07-21 09:56:29'),
(29, '', NULL, '2015-11-11 12:00:44');

--
-- Sťahujem dáta pre tabuľku `language`
--

INSERT INTO `language` (`id`, `code`, `name`, `created_at`) VALUES
(1, 'SK', 'slovenčina', '2015-07-20 19:49:41'),
(2, 'CZ', 'čeština', '2015-07-20 19:49:41'),
(3, 'EN', 'angličtina', '2015-07-20 19:49:41');

--
-- Sťahujem dáta pre tabuľku `library`
--

INSERT INTO `library` (`id`, `name`, `details`, `address_id`, `updated_at`, `created_at`) VALUES
(1, 'nezadané', NULL, NULL, NULL, '2015-07-21 09:48:14'),
(2, 'XZ Central s.r.o – globálna centrála', NULL, 1, NULL, '2015-07-20 19:49:44'),
(3, 'XYZ s. r. o.', NULL, NULL, NULL, '2015-07-20 19:49:44');

--
-- Sťahujem dáta pre tabuľku `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1428089978),
('m130524_201442_init', 1428089986);

--
-- Sťahujem dáta pre tabuľku `publisher`
--

INSERT INTO `publisher` (`id`, `name`, `address_id`, `year`, `updated_at`, `created_at`) VALUES
(1, 'nezadané', NULL, NULL, NULL, '2015-07-20 19:49:42'),
(2, 'Perex, a. s.', NULL, NULL, NULL, '2015-07-20 19:49:42'),
(3, 'Vydavateľstvo Európa, s.r.o.', NULL, NULL, NULL, '2015-07-20 19:49:42'),
(4, 'Vydavateľstvo Eurostav, spol. s r.o.', NULL, NULL, NULL, '2015-07-20 19:49:42');

--
-- Sťahujem dáta pre tabuľku `status`
--

INSERT INTO `status` (`id`, `status`, `status_sk`, `created_at`) VALUES
(1, 'free', 'voľná', '2015-07-20 19:49:43'),
(2, 'lent', 'požičaná', '2015-07-20 19:49:43'),
(3, 'reserved', 'rezerovaná', '2015-07-20 19:49:43'),
(4, 'unavailable', 'nedostupná', '2015-07-20 19:49:43'),
(5, 'deleted', 'zmazaná', '2015-07-20 19:49:43');

--
-- Sťahujem dáta pre tabuľku `type`
--

INSERT INTO `type` (`id`, `type`, `type_sk`, `created_at`) VALUES
(1, 'book', 'kniha', '2015-07-20 19:49:42'),
(2, 'corporate literature', 'firemná literatúra', '2015-07-20 19:49:42'),
(3, 'magazine, newspaper', '', '2015-07-20 19:49:42');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
