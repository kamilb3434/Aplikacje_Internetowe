<?php

$prefix = $_SESSION['prefix'] ?? ''; // Jeśli nie ustawiono prefix, przyjmij pusty lub zdefiniuj domyślny


require_once __DIR__ . '/../../includes/db.php';



$hasloAdmin = password_hash('admin123', PASSWORD_DEFAULT);

$insert = [
    // Role
    "INSERT IGNORE INTO {$prefix}rola (nazwa) VALUES ('uczestnik'), ('administrator')",

    // Użytkownicy fikcyjni
    "INSERT IGNORE INTO {$prefix}uzytkownik (imie, nazwisko, email, haslo, data_urodzenia, adres_kod_pocztowy, adres_miejscowosc, adres_ulica, adres_nr_domu, rola_id)
     VALUES 
     ('Marcin', 'Gortat', 'marcin.gortat@gmail.com', '$hasloAdmin', '1992-06-23', '95-100', 'Łódź', 'Bałucka', '11', 1),
     ('Robert', 'Lewandowski', 'robert.lewandowski10@wp.pl', '$hasloAdmin', '2007-01-23', '10-101', 'Barcelona', 'Katalońska', '10', 1),
     ('Adam', 'Nawałka', 'adam.nawalka11@wp.pl', '$hasloAdmin', '1995-09-23', '90-100', 'Warszawa', 'Nawałkowska', '10', 2)",

    // Ogłoszenie
    "INSERT IGNORE INTO {$prefix}ogloszenie (tytul, tresc, plik, autor_id)
     VALUES ('Marcin Gortat', 'Schowaj ego do kieszeni', '', 3)",

    // Referaty
    "INSERT IGNORE INTO {$prefix}referaty (tytul, streszczenie, plik, uczestnik_id, status)
     VALUES 
     ('Jestem najlepszym koszykarzem', 'Cześć jestem Marcin i kiedyś rządziłem w NBA! YOOOOO!', '1750701360_marcin_gortat_fakty.pdf', 3, 'oczekujący'),
     ('Probierz to słaby selekcjoner!', 'Ja jestem najlepszy i rządzę w kadrze, oto dowody w referacie!', '1750701690_robert_lewandowski_fakty.pdf', 4, 'zaakceptowany')"
];


try {
    foreach ($insert as $sql) {
        $pdo->exec($sql);
    }
} catch (PDOException $e) {
    die("Błąd podczas INSERT: " . $e->getMessage());
}
?>
