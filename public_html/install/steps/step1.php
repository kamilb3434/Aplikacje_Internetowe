<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Instalator – Krok 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Instalator aplikacji</span>
    </div>
</nav>

<main class="container mt-5 flex-grow-1">
    <h2 class="mb-4">Krok 1: Konfiguracja bazy danych</h2>

    <form method="post" action="install.php?step=2">
        <div class="mb-3">
            <label for="db_host" class="form-label">Host bazy danych</label>
            <input type="text" class="form-control" id="db_host" name="db_host" placeholder="np. localhost" required>
        </div>

        <div class="mb-3">
            <label for="db_user" class="form-label">Użytkownik bazy danych</label>
            <input type="text" class="form-control" id="db_user" name="db_user" placeholder="np. root" required>
        </div>

        <div class="mb-3">
            <label for="db_pass" class="form-label">Hasło</label>
            <input type="password" class="form-control" id="db_pass" name="db_pass">
        </div>

        <div class="mb-3">
            <label for="db_name" class="form-label">Nazwa bazy danych</label>
            <input type="text" class="form-control" id="db_name" name="db_name" required>
        </div>

        <div class="mb-3">
            <label for="prefix" class="form-label">Prefiks tabel (opcjonalny)</label>
            <input type="text" class="form-control" id="prefix" name="prefix" placeholder="np. konf_">
        </div>

        <button type="submit" class="btn btn-primary">Przejdź dalej</button>
    </form>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Instalator aplikacji 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
