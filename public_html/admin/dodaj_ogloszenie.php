<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id']) || (int)$_SESSION['rola_id'] !== 2) {
    header("Location: ../login.php");
    exit;
}

$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];

$blad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul    = trim($_POST['tytul'] ?? '');
    $tresc    = trim($_POST['tresc'] ?? '');
    $autor_id = (int)$_SESSION['user_id'];
    // UWAGA: jeśli kolumna `plik` w DB jest NOT NULL, trzymaj pusty string gdy brak pliku:
    $plik_nazwa = '';

    if ($tytul === '' || $tresc === '') {
        $blad = 'Uzupełnij tytuł i treść.';
    }

    // Upload (opcjonalny)
    if (!$blad && !empty($_FILES['plik']['name'])) {
        if ($_FILES['plik']['error'] !== UPLOAD_ERR_OK) {
            $blad = 'Błąd uploadu (kod ' . $_FILES['plik']['error'] . ').';
        } else {
            $ext = strtolower(pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf', 'html', 'htm'], true)) {
                $blad = 'Dozwolone są tylko pliki PDF lub HTML.';
            } else {
                $uploadDir = __DIR__ . '/../uploads/ogloszenia';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }
                $safeBase   = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['plik']['name']));
                $plik_nazwa = time() . '_' . $safeBase;
                $dest       = $uploadDir . DIRECTORY_SEPARATOR . $plik_nazwa;

                if (!move_uploaded_file($_FILES['plik']['tmp_name'], $dest)) {
                    $blad = 'Nie udało się zapisać pliku na serwerze.';
                }
            }
        }
    }

    if (!$blad) {
        $stmt = $pdo->prepare("
            INSERT INTO `{$prefix}ogloszenie` (tytul, tresc, plik, autor_id, data_dodania)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$tytul, $tresc, $plik_nazwa, $autor_id]);

        header("Location: ogloszenia.php?ok=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj ogłoszenie</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <nav class="navbar navbar-light bg-light mb-4">
        <a class="navbar-brand" href="ogloszenia.php">Panel administratora — Ogłoszenia</a>
        <a class="btn btn-outline-danger" href="../logout.php">Wyloguj się</a>
    </nav>

    <h2 class="mb-3">Dodaj ogłoszenie</h2>

    <?php if ($blad): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($blad, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="tytul">Tytuł:</label>
            <input type="text" id="tytul" name="tytul" class="form-control" maxlength="255" required>
        </div>

        <div class="form-group mb-3">
            <label for="tresc">Treść:</label>
            <textarea id="tresc" name="tresc" class="form-control" rows="6" required></textarea>
        </div>

        <div class="form-group mb-4">
            <label for="plik">Plik (PDF/HTML – opcjonalnie):</label>
            <input type="file" id="plik" name="plik" class="form-control"
                   accept=".pdf,.html,.htm,application/pdf,text/html">
        </div>

        <button type="submit" class="btn btn-primary">Dodaj ogłoszenie</button>
        <a href="ogloszenia.php" class="btn btn-secondary ms-2">Anuluj</a>
    </form>
</body>
</html>
