<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Pobranie prefixu z konfiguracji
$config = include '../includes/config.php';
$prefix = $config['prefix'];

// Pobranie ogłoszeń z uwzględnieniem prefixu
$ogloszenia = $pdo->query("SELECT * FROM `{$prefix}ogloszenie` ORDER BY data_dodania DESC")->fetchAll();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogłoszenia</title>
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
    <h2 class="mb-4">Ogłoszenia od organizatorów</h2>

    <?php if ($ogloszenia): ?>
        <?php foreach ($ogloszenia as $og): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($og['tytul']); ?></h5>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($og['tresc'])); ?></p>
                    <p class="card-text"><small class="text-muted">Dodano: <?php echo $og['data_dodania']; ?></small></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak ogłoszeń do wyświetlenia.</p>
    <?php endif; ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
