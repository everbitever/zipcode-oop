-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Kwi 2022, 20:03
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zipcode`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220406094537', '2022-04-06 11:45:47', 570);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `town`
--

CREATE TABLE `town` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `town`
--

INSERT INTO `town` (`id`, `name`) VALUES
(1, 'Gdańsk'),
(3, 'Wrocław'),
(4, 'Toruń'),
(5, 'Rzeszów'),
(6, 'Katowice'),
(7, 'Warszawa'),
(9, 'Płock');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zipcode`
--

CREATE TABLE `zipcode` (
  `id` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `zipcode`
--

INSERT INTO `zipcode` (`id`, `town_id`, `code`) VALUES
(1, 1, '01-255'),
(2, 5, '35-258'),
(3, 6, '78-258'),
(4, 4, '01-258'),
(6, 3, '99-663'),
(9, 7, '05-888'),
(10, 1, '01-251'),
(11, 7, '01-009');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indeksy dla tabeli `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zipcode`
--
ALTER TABLE `zipcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_550C01C275E23604` (`town_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `town`
--
ALTER TABLE `town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `zipcode`
--
ALTER TABLE `zipcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `zipcode`
--
ALTER TABLE `zipcode`
  ADD CONSTRAINT `FK_550C01C275E23604` FOREIGN KEY (`town_id`) REFERENCES `town` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
