<?php

$prefix = $_SESSION['prefix'];
require_once __DIR__ . '/../../includes/db.php';

$create = [
    "CREATE TABLE IF NOT EXISTS `{$prefix}rola` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `nazwa` VARCHAR(50) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `nazwa` (`nazwa`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `{$prefix}uzytkownik` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `imie` VARCHAR(50) NOT NULL,
      `nazwisko` VARCHAR(50) NOT NULL,
      `email` VARCHAR(100) NOT NULL,
      `haslo` VARCHAR(255) NOT NULL,
      `data_urodzenia` DATE DEFAULT NULL,
      `adres_kod_pocztowy` VARCHAR(10) DEFAULT NULL,
      `adres_miejscowosc` VARCHAR(50) DEFAULT NULL,
      `adres_ulica` VARCHAR(50) DEFAULT NULL,
      `adres_nr_domu` VARCHAR(10) DEFAULT NULL,
      `adres_nr_lokalu` VARCHAR(10) DEFAULT NULL,
      `rola_id` INT(11) NOT NULL DEFAULT 1,
      `data_rejestracji` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
      `status` TINYINT(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`),
      KEY `rola_id` (`rola_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `{$prefix}ogloszenie` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `tytul` VARCHAR(255) NOT NULL,
      `tresc` TEXT NOT NULL,
      `plik` VARCHAR(255) DEFAULT NULL,
      `data_dodania` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
      `autor_id` INT(11) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `autor_id` (`autor_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `{$prefix}plik` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `nazwa` VARCHAR(255) NOT NULL,
      `sciezka` VARCHAR(255) NOT NULL,
      `typ` ENUM('html','pdf') NOT NULL,
      `data_dodania` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
      `dodany_przez` INT(11) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `dodany_przez` (`dodany_przez`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `{$prefix}referaty` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `tytul` VARCHAR(255) NOT NULL,
      `streszczenie` TEXT NOT NULL,
      `plik` VARCHAR(255) DEFAULT NULL,
      `uczestnik_id` INT(11) NOT NULL,
      `data_zgloszenia` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
      `status` ENUM('oczekujący','zaakceptowany','odrzucony') NOT NULL DEFAULT 'oczekujący',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
];

// Osobno wykonaj ALTER TABLE z zabezpieczeniem przed błędem
$alters = [
    "ALTER TABLE `{$prefix}uzytkownik` 
        ADD CONSTRAINT `fk_uzytkownik_rola` 
        FOREIGN KEY (`rola_id`) REFERENCES `{$prefix}rola`(`id`);",

    "ALTER TABLE `{$prefix}ogloszenie` 
        ADD CONSTRAINT `fk_ogloszenie_autor` 
        FOREIGN KEY (`autor_id`) REFERENCES `{$prefix}uzytkownik`(`id`);",

    "ALTER TABLE `{$prefix}plik` 
        ADD CONSTRAINT `fk_plik_dodany` 
        FOREIGN KEY (`dodany_przez`) REFERENCES `{$prefix}uzytkownik`(`id`);"
];

try {
    require_once '../includes/db.php'; // zakładam że $pdo (PDO) jest tam dostępne
    foreach ($create as $query) {
        $pdo->exec($query);
    }

    foreach ($alters as $query) {
        try {
            $pdo->exec($query);
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'Duplicate') || str_contains($e->getMessage(), 'exists')) {
                // ignoruj, constraint już istnieje
            } else {
                throw $e; // inny błąd – pokaż
            }
        }
    }
} catch (PDOException $e) {
    die("❌ Błąd SQL: " . $e->getMessage());
}
?>
