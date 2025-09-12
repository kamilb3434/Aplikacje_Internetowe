<?php
// 1) jeśli nie ma configa → do instalatora
if (!file_exists(__DIR__ . '/includes/config.php')) {
    header('Location: /install/install.php');
    exit;
}

session_start();

// 2) spróbuj połączyć się z DB; jeśli błąd → do instalatora
try {
    require_once __DIR__ . '/includes/db.php'; // tworzy $pdo albo rzuci wyjątek
} catch (Throwable $e) {
    header('Location: /install/install.php');
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']) && $_SESSION['rola_id'] == 1;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Serwis konfernecyjny</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand" href="#page-top">Serwis konferencyjny</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#about">O serwisie</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Usługi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Kontakt</a></li>
                        <li class="nav-item"><a class="nav-link" href="/login.php">Zaloguj się</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register.php">Zarejestruj się</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="hero-section text-white d-flex align-items-center">
            <div class="container text-center">
                <h1 class="display-4 fw-bold">Witamy w serwisie konfernecyjnym!</h1>
                <p class="lead">Dołącz do nas i stań się częścią świata nauki!</p>
                <a href="#about" class="btn btn-light btn-lg mt-3">Dowiedz się wiecej!</a>
            </div>
        </header>

        <section id="about">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>O serwisie</h2>
                        <p class="lead text-justify">Serwis konferencyjny to internetowa platforma stworzona z myślą o wspieraniu organizacji konferencji naukowych. Umożliwia on kompleksowe zarządzanie wydarzeniem — od rejestracji uczestników, przez zgłaszanie referatów, aż po publikację ogłoszeń i materiałów konferencyjnych.</p>
                        <p class="lead text-justify">Projekt zakłada stworzenie prostego i funkcjonalnego systemu działającego w środowisku LAMP, który umożliwia sprawną komunikację między organizatorami a uczestnikami konferencji. Intuicyjny interfejs sprawia, że użytkownicy z łatwością korzystają z kluczowych funkcji serwisu.</p>
                        <p class="lead text-justify">System wspiera kompleksową obsługę konferencji oraz pozwala na dostęp do najważniejszych informacji o wydarzeniu. Został zaprojektowany tak, aby uprościć proces organizacji i ograniczyć czas potrzebny na zarządzanie jej przebiegiem.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light" id="services">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Cele projektu</h2>
                        <p class="lead text-justify">Serwis konferencyjny został stworzony w celach edukacyjnych przez Patrycję Calińską oraz Kamila Baranowskiego. Projekt powstał jako element nauki programowania aplikacji webowych, z wykorzystaniem technologii PHP, HTML, CSS oraz baz danych MySQL. Głównym celem było praktyczne wdrożenie wiedzy z zakresu tworzenia systemów z autoryzacją, zarządzaniem danymi użytkowników oraz obsługą dynamicznych treści.</p>
                        <ul>
                            <li>Linux</li>
                            <li>Apache</li>
                            <li>MySql</li>
                            <li>PHP</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" style="padding: 60px 0; background-color: #f8f9fa;">
          <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="font-size: 32px; margin-bottom: 20px;">Skontaktuj się z nami</h2>
            <p style="font-size: 16px; color: #666; margin-bottom: 40px;">
              Masz pytania dotyczące konferencji? Napisz do nas – chętnie pomożemy!
            </p>
            <form style="display: flex; flex-direction: column; gap: 15px;">
              <input type="text" placeholder="Imię i nazwisko" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px;" required>
              <input type="email" placeholder="Adres e-mail" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px;" required>
              <textarea placeholder="Wiadomość..." rows="5" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px;" required></textarea>
              <button type="submit" style="padding: 12px; background-color:rgb(7, 14, 21); color: white; border: none; border-radius: 8px; cursor: pointer;">
                Wyślij wiadomość
              </button>
            </form>
          </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container px-4"><p class="m-0 text-center text-white">&copy; Serwis konferencyjny 2025</p></div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>

        <style>
        .hero-section {
          background-image: url('css/images/building-bg.png');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          background-color: #000;
          height: 100vh;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          color: white;
          text-align: center;
          position: relative;
          padding: 0 20px;
        }
        .hero-section::before {
          content: "";
          position: absolute;
          top: 0; left: 0; right: 0; bottom: 0;
          background-color: rgba(0, 0, 0, 0.4);
          z-index: 0;
        }
        .hero-section * { position: relative; z-index: 1; }
        </style>
    </body>
</html>
