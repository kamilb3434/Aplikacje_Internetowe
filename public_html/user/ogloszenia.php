<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];

// jeśli ogłoszenia mają być publiczne – usuń wymóg logowania


// pobierz listę ogłoszeń (tylko to, co potrzebne)
$stmt = $pdo->query("SELECT id, tytul, tresc, data_dodania, plik FROM `{$prefix}ogloszenie` ORDER BY data_dodania DESC");
$ogloszenia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogłoszenia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="userDashboard.php">Panel użytkownika</a>
        <a href="../logout.php" class="btn btn-outline-light">Wyloguj</a>
    </div>
</nav>

<main class="container mt-4 mb-5 flex-grow-1">
    <h2 class="mb-4">Ogłoszenia</h2>

    <?php if (empty($ogloszenia)): ?>
        <p>Brak ogłoszeń.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                <tr>
                    <th style="width: 30%;">Tytuł</th>
                    <th>Treść</th>
                    <th style="width: 170px;">Data</th>
                    <th style="width: 160px;">Załącznik</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ogloszenia as $og): ?>
                    <tr>
                        <td><?= htmlspecialchars($og['tytul'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= nl2br(htmlspecialchars($og['tresc'], ENT_QUOTES, 'UTF-8')) ?></td>
                        <td><?= htmlspecialchars($og['data_dodania'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php if (!empty($og['plik'])): ?>
                                <a class="btn btn-sm btn-outline-primary me-2"
                                   href="/download_ogloszenie.php?id=<?= (int)$og['id'] ?>"
                                   target="_blank" rel="noopener">Otwórz</a>
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="/download_ogloszenie.php?id=<?= (int)$og['id'] ?>&dl=1"
                                   rel="noopener">Pobierz</a>
                            <?php else: ?>
                                <span class="text-muted">Brak</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>
</body>
</html>
