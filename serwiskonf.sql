-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 18, 2025 at 12:56 AM
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
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktura tabeli dla tabeli `referat`
--

CREATE TABLE `referat` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `streszczenie` text DEFAULT NULL,
  `plik_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `uczestnik_id` int(11) NOT NULL,
  `data_zgloszenia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `data_rejestracji` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `data_urodzenia`, `adres_kod_pocztowy`, `adres_miejscowosc`, `adres_ulica`, `adres_nr_domu`, `adres_nr_lokalu`, `rola_id`, `data_rejestracji`) VALUES
(4, 'Jacek', 'Kaczmarek', 'seniorita123@gmail.com', '$2y$10$x7CbT8vI0e5zTJiVCXM0Y./akNrR7Lagm9bXo8EWB2QBvWEPePZf2', '2025-05-28', '00-000', 'Łódź', 'biedronkowa', '10', NULL, 2, '2025-06-16 21:01:48'),
(5, 'Krzysztof', 'Sągała', 'krzysiuDzbaneJebali@gmail.com', '$2y$10$TLh40a6zBZmUhmivJKs5Yu9YL3QoHD/iGR99hGoYnYx4..3TkiHa.', '2025-06-11', '12-123', 'Lodz', 'Pokątna', '12', '', 1, '2025-06-16 21:05:23');

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
-- Indeksy dla tabeli `referat`
--
ALTER TABLE `referat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plik_id` (`plik_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `uczestnik_id` (`uczestnik_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plik`
--
ALTER TABLE `plik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referat`
--
ALTER TABLE `referat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `referat`
--
ALTER TABLE `referat`
  ADD CONSTRAINT `referat_ibfk_1` FOREIGN KEY (`plik_id`) REFERENCES `plik` (`id`),
  ADD CONSTRAINT `referat_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `referat_status` (`id`),
  ADD CONSTRAINT `referat_ibfk_3` FOREIGN KEY (`uczestnik_id`) REFERENCES `uzytkownik` (`id`);

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`rola_id`) REFERENCES `rola` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
