-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: St 11.Nov 2015, 13:41
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

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `address`
--

CREATE TABLE `address` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `street` varchar(50) NOT NULL,
  `street_number` varchar(20) NOT NULL,
  `zip` varchar(12) DEFAULT NULL,
  `city_id` smallint(5) UNSIGNED NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `author`
--

CREATE TABLE `author` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `book`
--

CREATE TABLE `book` (
  `id` int(10) UNSIGNED NOT NULL,
  `internal_id` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `page_count` smallint(5) UNSIGNED DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `issn` varchar(20) DEFAULT NULL,
  `language_id` tinyint(3) UNSIGNED NOT NULL,
  `library_id` int(10) UNSIGNED NOT NULL,
  `publisher_id` int(10) UNSIGNED NOT NULL,
  `type_id` tinyint(3) UNSIGNED NOT NULL,
  `status_id` tinyint(3) UNSIGNED NOT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `edition` tinyint(3) UNSIGNED DEFAULT NULL,
  `description` mediumtext,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `book_author`
--

CREATE TABLE `book_author` (
  `book_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `book_key_word`
--

CREATE TABLE `book_key_word` (
  `book_id` int(10) UNSIGNED NOT NULL,
  `key_word_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `category`
--

CREATE TABLE `category` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `city`
--

CREATE TABLE `city` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `city` varchar(50) NOT NULL,
  `country_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `country`
--

CREATE TABLE `country` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `country` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `key_word`
--

CREATE TABLE `key_word` (
  `id` int(10) UNSIGNED NOT NULL,
  `word` varchar(45) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `language`
--

CREATE TABLE `language` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(8) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `library`
--

CREATE TABLE `library` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `details` varchar(45) DEFAULT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `log_book`
--

CREATE TABLE `log_book` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text,
  `message` text,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `log_login`
--

CREATE TABLE `log_login` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `payment`
--

CREATE TABLE `payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `staff_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `publisher`
--

CREATE TABLE `publisher` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rental`
--

CREATE TABLE `rental` (
  `id` int(10) UNSIGNED NOT NULL,
  `requested_date` timestamp NULL DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `other_detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rental_book`
--

CREATE TABLE `rental_book` (
  `rental_id` int(10) UNSIGNED NOT NULL,
  `book_id` int(10) UNSIGNED NOT NULL,
  `rental_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `returned_date` timestamp NULL DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `rental_count` tinyint(4) DEFAULT NULL,
  `rental_staff_id` int(11) UNSIGNED DEFAULT NULL,
  `return_staff_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `status`
--

CREATE TABLE `status` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(45) NOT NULL,
  `status_sk` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `type`
--

CREATE TABLE `type` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `type` varchar(45) NOT NULL,
  `type_sk` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'MgqIZm3Zi0HjGZcsZHoB0TkPX-ccruNX', '$2y$13$bmJ9EqhPCFyFth82HtW4v.8aCmhRaVv0kQdUCa.eOWl5DYJc7oDce', NULL, 'admin@admin.sk', 10, 1428652311, 1428652311);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_address_city1_idx` (`city_id`);

--
-- Indexy pre tabuľku `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `internal_id_UNIQUE` (`internal_id`),
  ADD KEY `fk_book_language1_idx` (`language_id`),
  ADD KEY `fk_book_publisher1_idx` (`publisher_id`),
  ADD KEY `fk_book_type1_idx` (`type_id`),
  ADD KEY `fk_book_status1_idx` (`status_id`),
  ADD KEY `fk_book_library1_idx` (`library_id`),
  ADD KEY `fk_book_category1_idx` (`category_id`);

--
-- Indexy pre tabuľku `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`book_id`,`author_id`),
  ADD KEY `fk_book_author_author1_idx` (`author_id`),
  ADD KEY `fk_book_author_book1_idx` (`book_id`);

--
-- Indexy pre tabuľku `book_key_word`
--
ALTER TABLE `book_key_word`
  ADD PRIMARY KEY (`book_id`,`key_word_id`),
  ADD KEY `fk_book_key_word_key_word1_idx` (`key_word_id`),
  ADD KEY `fk_book_key_word_book1_idx` (`book_id`);

--
-- Indexy pre tabuľku `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_city_country1_idx` (`country_id`);

--
-- Indexy pre tabuľku `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `key_word`
--
ALTER TABLE `key_word`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_library_address1_idx` (`address_id`);

--
-- Indexy pre tabuľku `log_book`
--
ALTER TABLE `log_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_book_user1_idx` (`user_id`);

--
-- Indexy pre tabuľku `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_login_user1_idx` (`user_id`);

--
-- Indexy pre tabuľku `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexy pre tabuľku `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_user1_idx` (`user_id`),
  ADD KEY `fk_payment_user2_idx` (`staff_id`);

--
-- Indexy pre tabuľku `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publisher_address1_idx` (`address_id`);

--
-- Indexy pre tabuľku `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rental_user2_idx` (`user_id`);

--
-- Indexy pre tabuľku `rental_book`
--
ALTER TABLE `rental_book`
  ADD PRIMARY KEY (`rental_id`,`book_id`),
  ADD KEY `fk_rental_book_book1_idx` (`book_id`),
  ADD KEY `fk_rental_book_rental1_idx` (`rental_id`),
  ADD KEY `fk_rental_book_payment1_idx` (`payment_id`),
  ADD KEY `fk_rental_book_user1_idx` (`rental_staff_id`),
  ADD KEY `fk_rental_book_user2_idx` (`return_staff_id`);

--
-- Indexy pre tabuľku `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `address`
--
ALTER TABLE `address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pre tabuľku `author`
--
ALTER TABLE `author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pre tabuľku `book`
--
ALTER TABLE `book`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pre tabuľku `category`
--
ALTER TABLE `category`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pre tabuľku `city`
--
ALTER TABLE `city`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pre tabuľku `country`
--
ALTER TABLE `country`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pre tabuľku `key_word`
--
ALTER TABLE `key_word`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pre tabuľku `language`
--
ALTER TABLE `language`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pre tabuľku `library`
--
ALTER TABLE `library`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pre tabuľku `log_book`
--
ALTER TABLE `log_book`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pre tabuľku `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pre tabuľku `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pre tabuľku `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pre tabuľku `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pre tabuľku `status`
--
ALTER TABLE `status`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pre tabuľku `type`
--
ALTER TABLE `type`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_language1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_library1` FOREIGN KEY (`library_id`) REFERENCES `library` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_publisher1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fk_book_author_author1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_author_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `book_key_word`
--
ALTER TABLE `book_key_word`
  ADD CONSTRAINT `fk_book_has_key_word_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_has_key_word_key_word1` FOREIGN KEY (`key_word_id`) REFERENCES `key_word` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_city_country1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `fk_library_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `log_book`
--
ALTER TABLE `log_book`
  ADD CONSTRAINT `fk_log_book_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `log_login`
--
ALTER TABLE `log_login`
  ADD CONSTRAINT `fk_log_login_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_payment_user2` FOREIGN KEY (`staff_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `publisher`
--
ALTER TABLE `publisher`
  ADD CONSTRAINT `fk_publisher_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `fk_rental_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Obmedzenie pre tabuľku `rental_book`
--
ALTER TABLE `rental_book`
  ADD CONSTRAINT `fk_rental_book_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rental_book_payment1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rental_book_rental1` FOREIGN KEY (`rental_id`) REFERENCES `rental` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rental_book_user1` FOREIGN KEY (`rental_staff_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rental_book_user2` FOREIGN KEY (`return_staff_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
