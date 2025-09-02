<?php
session_start();
require_once '../includes/db.php';

// Pobranie prefixu z configu
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Zapytanie z użyciem prefixu
$pliki = $pdo->query("SELECT * FROM `{$prefix}plik` ORDER BY data_dodania DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dostępne pliki</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="userDashboard.php">Panel użytkownika</a>
        <a href="../logout.php" class="btn btn-outline-light">Wyloguj</a>
    </div>
</nav>

<main class="container mt-4 flex-grow-1">
    <h2 class="mb-4">Pliki do pobrania</h2>

    <?php if ($pliki): ?>
        <ul class="list-group">
            <?php foreach ($pliki as $plik): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($plik['nazwa']); ?></strong>
                        <br><small class="text-muted">Typ: <?php echo $plik['typ']; ?></small>
                    </div>
                    <a href="../uploads/<?php echo htmlspecialchars($plik['sciezka']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">Pobierz</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Brak plików do pobrania.</p>
    <?php endif; ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
