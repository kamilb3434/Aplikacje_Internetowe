# Serwis konferencyjny

Serwis konferencyjny to internetowa platforma stworzona z myślą o wspieraniu organizacji konferencji naukowych.  
Umożliwia kompleksowe zarządzanie wydarzeniem — od rejestracji uczestników, przez zgłaszanie referatów, aż po publikację ogłoszeń i materiałów konferencyjnych.

---

## Wymagania systemowe
- **Serwer WWW:** Apache 2.4 lub nowszy  
- **PHP:** 7.4 lub nowszy (zalecane PHP 8.x)  
- **Baza danych:** MySQL 5.7 lub nowsza (alternatywnie MariaDB 10.x)  

---

## Instalacja
Po pobraniu i umieszczeniu aplikacji na serwerze WWW z obsługą PHP oraz MySQL (np. Apache w środowisku Linux), instalacja odbywa się za pomocą wbudowanego instalatora.

### 1. Uruchomienie instalatora
W przeglądarce internetowej należy wpisać adres: http://localhost

Spowoduje to wyświetlenie formularza instalacyjnego aplikacji.

### 2. Konfiguracja bazy danych
W pierwszym kroku należy podać dane dostępowe do bazy danych:
- **Host bazy danych** –  `localhost`,  
- **Użytkownik bazy danych** – np. `root`,  
- **Hasło** – pole jest dostępne w formularzu, jednak w standardowej konfiguracji nie wymaga uzupełniania.  

  > W projekcie konto `root` w MySQL pozostało bez hasła, ponieważ w środowisku XAMPP domyślnie nie ma możliwości jego ustawienia bez dodatkowej konfiguracji. Próba nadania hasła powodowała błędy w aplikacji (problemy z połączeniem do bazy).  
  > W związku z tym pozostawiono konto `root` bez hasła, aby aplikacja działała poprawnie w środowisku testowym.

- **Nazwa bazy danych** – np. `serwiskonf`,  
- **Prefiks tabel** – opcjonalnie można ustawić prefiks, np. `konf_`.  

Po uzupełnieniu danych klikamy przycisk **Przejdź dalej**.

### 3. Dane aplikacji i administratora
W kolejnym kroku uzupełniamy dane dotyczące aplikacji:
- Nazwa aplikacji – np. `serwiskonf`,  
- Adres serwisu – np. `localhost`,  
- Wersja aplikacji – np. `1`,  
- Nazwa firmy – np. `xxxx`,  
- Numer telefonu kontaktowego – np. `123456789`.  

Następnie definiujemy dane administratora systemu:
- Adres e-mail administratora – np. `admin123@wp.pl`,  
- Hasło oraz jego potwierdzenie.  

Po wprowadzeniu wszystkich informacji wybieramy przycisk **Zakończ instalację**.

### 4. Zakończenie instalacji
Jeśli wszystkie dane zostały poprawnie uzupełnione, pojawi się komunikat:
**„Instalacja zakończona!”**

Klikając w odnośnik **Przejdź do aplikacji**, użytkownik zostaje przeniesiony na stronę główną systemu.

- Aby uzyskać dostęp do panelu administracyjnego, należy kliknąć przycisk **Zaloguj się** i wprowadzić dane administratora utworzone w trakcie instalacji (adres e-mail i hasło).  
- Po poprawnym zalogowaniu użytkownik trafia na **ekran administratora**.  
- Alternatywnie nowi użytkownicy mogą skorzystać z opcji **Rejestracja**, aby utworzyć własne konto i zalogować się do systemu jako zwykły użytkownik.  

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