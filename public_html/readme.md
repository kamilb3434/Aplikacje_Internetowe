# Serwis konferencyjny

Serwis konferencyjny to internetowa platforma stworzona z myślą o wspieraniu organizacji konferencji naukowych.  
Umożliwia kompleksowe zarządzanie wydarzeniem — od rejestracji uczestników, przez zgłaszanie referatów, aż po publikację ogłoszeń i materiałów konferencyjnych.

---

## Wymagania systemowe

- **Serwer WWW:** Apache/2.4.58 (Win64), OpenSSL/3.1.3  
- **PHP:** 8.2.12 _(zalecane PHP 8.x)_  
- **Baza danych:** MySQL (libmysql - mysqlnd 8.2.12)  
- **Rozszerzenia PHP:**  
  - `mysqli`  
  - `curl`  
  - `mbstring`

---

## Instalacja

Po pobraniu i umieszczeniu aplikacji na serwerze WWW z obsługą PHP i MySQL (np. Apache w środowisku Linux lub Windows), instalacja przebiega za pomocą wbudowanego instalatora.

---

### 1. Uruchomienie instalatora

W przeglądarce internetowej wpisz adres: http://localhost
Spowoduje to wyświetlenie formularza instalacyjnego aplikacji.

### 2. Konfiguracja bazy danych

W pierwszym kroku podaj dane dostępowe do bazy danych:

- **Host bazy danych** – `localhost` 
- **Nazwa bazy danych** – np. `serwiskonf`  
- **Użytkownik bazy** –  `root`  
- **Hasło bazy** – w przypadku instalacji lokalnej (localhost) **pozostaw puste**  
- **Prefiks tabel** – np. `konf_`  

Po uzupełnieniu danych kliknij przycisk **Dalej**.

Kolejno wykonaj następujące kroki:

1. Kliknij odnośnik **„Kliknij tutaj”**, aby rozpocząć tworzenie bazy danych.  
2. Po zakończeniu procesu ponownie wybierz **„Kliknij tutaj”**, aby przejść dalej.  
3. Wyświetli się komunikat o dodawaniu danych startowych – ponownie kliknij **„Kliknij tutaj”**, aby zakończyć ten etap.  

---

### 3. Dane aplikacji i administratora

W kolejnym kroku uzupełnij dane dotyczące aplikacji:

- **Adres bazowy** – `http://localhost/` 
- **Nazwa aplikacji** – np. `Serwis konferencyjny`   
- **Wersja aplikacji** – np. `beta`  
- **Brand** – np. `Przykładowa Firma`  
- **Numer telefonu** – np. `123456789`  

Następnie zdefiniuj dane administratora systemu:

- **Adres e-mail administratora** – np. `admin123@wp.pl`  
- **Hasło** oraz jego **potwierdzenie**  

Po wprowadzeniu wszystkich informacji kliknij przycisk **Zakończ instalację**.

### 4. Zakończenie instalacji

Po pomyślnym zakończeniu instalacji pojawi się komunikat:

**„Instalacja zakończona!”**

Klikając w odnośnik **Przejdź do aplikacji**, zostaniesz przeniesiony na stronę główną systemu.

- Aby uzyskać dostęp do panelu administracyjnego, kliknij przycisk **Zaloguj się** i wprowadź dane administratora utworzone w trakcie instalacji.  
- Po poprawnym zalogowaniu trafisz na **ekran administratora**.  
- Nowi użytkownicy mogą skorzystać z opcji **Rejestracja**, aby założyć własne konto i korzystać z systemu jako zwykli użytkownicy.

---

## Autorzy

- **Patrycja Calińska**  
  *nr albumu: 414771*  
  *calinska*  

- **Kamil Baranowski**  
  *nr albumu: 405785*  
  *baranokk*  

---

## Wykorzystane zewnętrzne biblioteki
- [Bootstrap 5.3](https://getbootstrap.com/) – framework CSS/JS do stylizacji i komponentów interfejsu.  

---