<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Krok 5 – Konfiguracja aplikacji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Instalator aplikacji</span>
    </div>
</nav>

<main class="container mt-5 flex-grow-1">
    <h2 class="mb-4">Krok 5: Dane aplikacji i administratora</h2>

    <form method="post" action="install.php?step=6">
        <div class="mb-3">
            <label for="nazwa_aplikacji" class="form-label">Nazwa aplikacji</label>
            <input type="text" class="form-control" id="nazwa_aplikacji" name="nazwa_aplikacji" required>
        </div>

        <div class="mb-3">
            <label for="base_url" class="form-label">Adres serwisu (URL)</label>
            <input type="text" class="form-control" id="base_url" name="base_url" required>
        </div>

        <div class="mb-3">
            <label for="wersja" class="form-label">Wersja aplikacji</label>
            <input type="text" class="form-control" id="wersja" name="wersja" required>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Nazwa firmy</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telefon kontaktowy</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <hr class="my-4">

        <h4>Dane administratora</h4>

        <div class="mb-3">
            <label for="admin_login" class="form-label">Email administratora</label>
            <input type="email" class="form-control" id="admin_login" name="admin_login" required>
        </div>

        <div class="mb-3">
            <label for="passwd" class="form-label">Hasło</label>
            <input type="password" class="form-control" id="passwd" name="passwd" required>
        </div>

        <div class="mb-3">
            <label for="passwd2" class="form-label">Powtórz hasło</label>
            <input type="password" class="form-control" id="passwd2" name="passwd2" required>
        </div>

        <button type="submit" class="btn btn-primary">Zakończ instalację</button>
    </form>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Instalator aplikacji 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
