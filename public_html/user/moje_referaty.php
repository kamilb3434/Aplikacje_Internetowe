<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Załaduj prefix z konfiguracji
$config = include '../includes/config.php';
$prefix = $config['prefix'];

$uczestnik_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT tytul, streszczenie, plik, data_zgloszenia, status FROM `{$prefix}referaty` WHERE uczestnik_id = ?");
$stmt->execute([$uczestnik_id]);
$referaty = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moje referaty</title>
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
    <h2 class="mb-4">Moje referaty</h2>

    <?php if (empty($referaty)): ?>
        <p>Nie zgłoszono jeszcze żadnych referatów.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tytuł</th>
                    <th>Data zgłoszenia</th>
                    <th>Status</th>
                    <th>Plik</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($referaty as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['tytul']) ?></td>
                        <td><?= $r['data_zgloszenia'] ?></td>
                        <td>
                            <?php
                                $kolor = match($r['status']) {
                                    'zaakceptowany' => 'success',
                                    'odrzucony' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?= $kolor ?>"><?= $r['status'] ?></span>
                        </td>
                        <td>
                            <?php if ($r['plik']): ?>
                                <a href="../pliki/<?= htmlspecialchars($r['plik']) ?>" target="_blank">Pobierz</a>
                            <?php else: ?>
                                Brak
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
