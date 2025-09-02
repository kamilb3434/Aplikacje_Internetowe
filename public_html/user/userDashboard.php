\<?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container px-4">
        <a class="navbar-brand" href="#">Serwis konferencyjny</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../logout.php">Wyloguj</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<main class="flex-grow-1 container mt-5 pt-5">
    <h2 class="mb-4">Witaj, <?php echo htmlspecialchars($_SESSION['imie']); ?>!</h2>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="profile.php" class="btn btn-outline-primary w-100">Edycja danych</a>
        </div>
        <div class="col-md-6">
            <a href="ogloszenia.php" class="btn btn-outline-secondary w-100">Przeglądaj ogłoszenia</a>
        </div>
        <div class="col-md-6">
            <a href="pliki.php" class="btn btn-outline-success w-100">Dostępne pliki</a>
        </div>
        <div class="col-md-6">
            <a href="zglos_referat.php" class="btn btn-outline-warning w-100">Zgłoś referat</a>
        </div>
        <div class="col-md-6">
            <a href="moje_referaty.php" class="btn btn-outline-info w-100">Moje referaty</a>
        </div>
        <div class="col-md-6">
            <a href="program_konferencji.php" class="btn btn-outline-info w-100">Program konferencji</a>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container px-4">
        &copy; Serwis konferencyjny 2025
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
