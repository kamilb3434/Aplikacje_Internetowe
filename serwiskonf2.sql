-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 23, 2025 at 07:14 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serwiskonf`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie`
--

CREATE TABLE `ogloszenie` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `tresc` text NOT NULL,
  `plik` varchar(255) NOT NULL,
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ogloszenie`
--

INSERT INTO `ogloszenie` (`id`, `tytul`, `tresc`, `plik`, `data_dodania`, `autor_id`) VALUES
(1, 'lskdcdvn dwjo', 'ola ola ola', '1750681919_Zadania - Refleksje.pdf', '2025-06-23 12:31:59', 8),
(3, 'wocjdsvdf boesj', 'iiiuunhiuhniuhiuhniuh', '', '2025-06-23 16:43:15', 8),
(4, 'hgufytttyf', 'lohuiuiuh', '', '2025-06-23 16:50:14', 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plik`
--

CREATE TABLE `plik` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `sciezka` varchar(255) NOT NULL,
  `typ` enum('html','pdf') NOT NULL,
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp(),
  `dodany_przez` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `referaty`
--

CREATE TABLE `referaty` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `streszczenie` text NOT NULL,
  `plik` varchar(255) NOT NULL,
  `uczestnik_id` int(11) NOT NULL,
  `data_zgloszenia` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('oczekujący','zaakceptowany','odrzucony') NOT NULL DEFAULT 'oczekujący'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referaty`
--

INSERT INTO `referaty` (`id`, `tytul`, `streszczenie`, `plik`, `uczestnik_id`, `data_zgloszenia`, `status`) VALUES
(1, 'olaolaola', 'bbbbaaaabbbbbaa', '1750687056_aktywnosci.pdf', 6, '2025-06-23 13:57:36', 'zaakceptowany'),
(2, 'nkjnnjkjnkjnkjn', 'kjnknnkjjnkjknnkjn', '', 6, '2025-06-23 15:03:17', 'odrzucony'),
(3, 'uhiihihiuhihoijuhiyh8y', 'bjubuyuuyg', '', 6, '2025-06-23 16:50:53', 'zaakceptowany');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `referat_status`
--

CREATE TABLE `referat_status` (
  `id` int(11) NOT NULL,
  `nazwa_statusu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referat_status`
--

INSERT INTO `referat_status` (`id`, `nazwa_statusu`) VALUES
(1, 'oczekujacy'),
(3, 'odrzucony'),
(2, 'zaakceptowany');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rola`
--

CREATE TABLE `rola` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rola`
--

INSERT INTO `rola` (`id`, `nazwa`) VALUES
(2, 'administrator'),
(1, 'uczestnik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `adres_kod_pocztowy` varchar(10) DEFAULT NULL,
  `adres_miejscowosc` varchar(50) DEFAULT NULL,
  `adres_ulica` varchar(50) DEFAULT NULL,
  `adres_nr_domu` varchar(10) DEFAULT NULL,
  `adres_nr_lokalu` varchar(10) DEFAULT NULL,
  `rola_id` int(11) NOT NULL DEFAULT 1,
  `data_rejestracji` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `data_urodzenia`, `adres_kod_pocztowy`, `adres_miejscowosc`, `adres_ulica`, `adres_nr_domu`, `adres_nr_lokalu`, `rola_id`, `data_rejestracji`, `status`) VALUES
(4, 'Jacek', 'Kaczmarek', 'seniorita123@gmail.com', '$2y$10$x7CbT8vI0e5zTJiVCXM0Y./akNrR7Lagm9bXo8EWB2QBvWEPePZf2', '2025-05-28', '11-111', 'Warszawa', 'biedronkowa', '10', '', 2, '2025-06-16 21:01:48', 1),
(5, 'Krzysztof', 'Sągała', 'krzysiuDzbaneJebali@gmail.com', '$2y$10$TLh40a6zBZmUhmivJKs5Yu9YL3QoHD/iGR99hGoYnYx4..3TkiHa.', '2025-06-11', '12-123', 'Lodz', 'Pok?tna', '12', '', 1, '2025-06-16 21:05:23', 1),
(6, 'Jakub', 'Bukaj', 'JakubJak@wp.pl', '$2y$10$uwuR1a50MwWjUGfY2RkdaeuxoY2Tr462giKb98xn5u4rgbfpk2bki', '2008-01-09', '97-200', 'Łódź', 'Zielona', '7', '', 1, '2025-06-18 08:08:40', 1),
(8, 'Adam', 'Kowalski', 'admin123@wp.pl', '$2y$10$epe6zXQfDxJo8lbIFbbD7ui93pl1VGa2QGImcSGeNFgnT1WXSXs86', '1997-11-11', '90-221', 'Łódź', 'Zielona', '7', NULL, 2, '2025-06-22 17:47:34', 1),
(9, 'Fabian', 'Nowak', 'fabiannowak@wp.pl', 'fabian123', '1997-11-11', '90-221', 'Łódź', 'Zielona', '77', NULL, 1, '2025-06-22 21:55:38', 1),
(11, 'Kamli', 'Nowakowski', 'kaminowak@wp.pl', 'kamil123', '1997-11-11', '90-221', 'Poznań', 'Piernikowa', '78', NULL, 1, '2025-06-23 11:18:16', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ogloszenie`
--
ALTER TABLE `ogloszenie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Indeksy dla tabeli `plik`
--
ALTER TABLE `plik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dodany_przez` (`dodany_przez`);

--
-- Indeksy dla tabeli `referaty`
--
ALTER TABLE `referaty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `referat_status`
--
ALTER TABLE `referat_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nazwa_statusu` (`nazwa_statusu`);

--
-- Indeksy dla tabeli `rola`
--
ALTER TABLE `rola`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nazwa` (`nazwa`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `rola_id` (`rola_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ogloszenie`
--
ALTER TABLE `ogloszenie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plik`
--
ALTER TABLE `plik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referaty`
--
ALTER TABLE `referaty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `referat_status`
--
ALTER TABLE `referat_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rola`
--
ALTER TABLE `rola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ogloszenie`
--
ALTER TABLE `ogloszenie`
  ADD CONSTRAINT `ogloszenie_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `uzytkownik` (`id`);

--
-- Constraints for table `plik`
--
ALTER TABLE `plik`
  ADD CONSTRAINT `plik_ibfk_1` FOREIGN KEY (`dodany_przez`) REFERENCES `uzytkownik` (`id`);

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`rola_id`) REFERENCES `rola` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
