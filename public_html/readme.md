# Tytuł projektu
Serwis konferencyjny

## Wymagania systemowe
* wersja apache'a
* wersja PHP'a
* wersja MySQL

## Instalacja
Instrukcja instalacji projektu, w tym do jakich plików i do jakich katalogów należy ustawić odpowiednie uprawnienia
🔧 Instrukcja uruchomienia i przetestowania instalatora aplikacji PHP
Poniżej znajdziesz krok po kroku, co zrobić po wrzuceniu plików na serwer, żeby odpalić Twój instalator i zainstalować aplikację poprawnie.

✅ Wymagania wstępne:
Serwer z PHP (>=7.4), MySQL/MariaDB, Apache lub inny webserwer (np. XAMPP, LAMP, itp.)

Dostęp do phpMyAdmin lub konto z uprawnieniami do tworzenia baz danych

Folder projektu wrzucony do htdocs/ (lokalnie) lub katalogu publicznego na serwerze

🪛 Krok 1: Ustaw odpowiednie uprawnienia do plików
Upewnij się, że:

folder install/config/ istnieje i ma prawo zapisu


chmod -R 775 install/config/
jeśli includes/config.php nie istnieje, to PHP będzie go tworzył – czyli folder includes/ też musi mieć prawo zapisu:


chmod -R 775 includes/
🧪 Krok 2: Uruchom instalator
Przejdź do przeglądarki i wpisz:


http://localhost/nazwa_aplikacji/install/install.php
lub na serwerze:


https://twojadomena.pl/install/install.php
Instalator sam poprowadzi Cię krok po kroku:

📋 Przebieg instalacji
🔹 Krok 1: Formularz danych bazy
Podajesz:

host (np. localhost)

nazwę bazy (np. 2026_baranokk)

użytkownika i hasło do MySQL

prefix tabel (np. serwis_)

Po zatwierdzeniu te dane zapisują się do config.php.

🔹 Krok 2–4: Tworzenie bazy i struktur
Tworzona jest baza (jeśli nie istnieje)

Wczytywane są zapytania z pliku sql/sql.php (tworzenie tabel)

Następnie wykonywane są inserty startowe z sql/insert.php

🔹 Krok 5: Dane aplikacji i administratora
Wypełniasz:

nazwa aplikacji, URL, wersja, firma, telefon

login (email) i hasło administratora

🔹 Krok 6: Kończenie instalacji
Tworzone jest konto administratora (rola_id = 2)

Dane aplikacji są dopisywane do config.php

Pojawi się komunikat:


✅ Instalacja zakończona!
[ Przejdź do aplikacji ]
🔒 Krok 3: Zabezpieczenie aplikacji po instalacji
Po zakończeniu instalacji:

Usuń lub zablokuj dostęp do install/:


rm -rf install/
Albo przynajmniej wrzuć do install/ plik .htaccess z:

ss

Deny from all
Sprawdź czy config.php zawiera dane połączenia i dane aplikacji.

✅ Testowanie
Wejdź na stronę logowania (login.php)

Zaloguj się danymi administratora

Upewnij się, że dashboard działa i dane z bazy się ładują

Przetestuj rejestrację zwykłego użytkownika, dodawanie referatów, ogłoszeń itd.

Jak coś nie działa – sprawdzaj:

config.php – czy są dobre dane?

php_error.log – czy nie ma błędów składni?

uprawnienia plików – czy może PHP nie może zapisywać?




## Autor

* **Patrycja Calińska** 
* *nr  album: 414771*
* *calinska*

* **Kamil Baranowski** 
* *nr  album: 405785*
* *baranokk*

## Wykorzystane zewnętrzne biblioteki

* bootstrap
