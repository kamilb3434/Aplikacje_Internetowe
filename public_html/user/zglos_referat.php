<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zgłoś referat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="userDashboard.php">Panel użytkownika</a>
        <a href="../logout.php" class="btn btn-outline-light">Wyloguj</a>
    </div>
</nav>

<main class="container mt-5 flex-grow-1">
    <h2 class="mb-4">Zgłoś referat</h2>

    <?php if (isset($_GET['sukces']) && $_GET['sukces'] == 1): ?>
        <div class="alert alert-success">Referat został zgłoszony pomyślnie!</div>
    <?php endif; ?>

    <form action="referat_handler.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tytul" class="form-label">Tytuł referatu</label>
            <input type="text" name="tytul" id="tytul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="streszczenie" class="form-label">Streszczenie</label>
            <textarea name="streszczenie" id="streszczenie" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="plik" class="form-label">Plik PDF (opcjonalnie)</label>
            <input type="file" name="plik" id="plik" class="form-control" accept=".pdf">
        </div>
        <button type="submit" class="btn btn-primary">Wyślij zgłoszenie</button>
    </form>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
