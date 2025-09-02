<?php

session_start();
require_once '../includes/db.php';

// Załaduj prefix
$config = include '../install/config/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ogloszenia.php");
    exit;
}

$id = (int) $_GET['id'];

// Pobierz istniejące ogłoszenie
$stmt = $pdo->prepare("SELECT * FROM {$prefix}ogloszenie WHERE id = ?");
$stmt->execute([$id]);
$ogloszenie = $stmt->fetch();

if (!$ogloszenie) {
    echo "Ogłoszenie nie istnieje.";
    exit;
}

$blad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];
    $plik_nazwa = $ogloszenie['plik']; // zachowaj stary plik domyślnie

    if (isset($_FILES['plik']) && $_FILES['plik']['error'] === UPLOAD_ERR_OK) {
        $rozszerzenie = pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION);
        if (in_array(strtolower($rozszerzenie), ['pdf', 'html'])) {
            $plik_nazwa = time() . '_' . basename($_FILES['plik']['name']);
            move_uploaded_file($_FILES['plik']['tmp_name'], 'pliki/' . $plik_nazwa);
        } else {
            $blad = 'Dozwolone są tylko pliki PDF i HTML.';
        }
    }

    if (!$blad) {
        $stmt = $pdo->prepare("UPDATE {$prefix}ogloszenie SET tytul = ?, tresc = ?, plik = ? WHERE id = ?");
        $stmt->execute([$tytul, $tresc, $plik_nazwa, $id]);
        header("Location: ogloszenia.php");
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj ogłoszenie</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <h2 class="mb-4">Edytuj ogłoszenie</h2>

    <?php if ($blad): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($blad) ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tytuł:</label>
            <input type="text" name="tytul" class="form-control" value="<?= htmlspecialchars($ogloszenie['tytul']) ?>" required>
        </div>
        <div class="form-group">
            <label>Treść:</label>
            <textarea name="tresc" class="form-control" rows="5" required><?= htmlspecialchars($ogloszenie['tresc']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Aktualny plik:
                <?php if ($ogloszenie['plik']): ?>
                    <a href="pliki/<?= htmlspecialchars($ogloszenie['plik']) ?>" target="_blank"><?= htmlspecialchars($ogloszenie['plik']) ?></a>
                <?php else: ?>
                    Brak
                <?php endif; ?>
            </label><br>
            <label>Nowy plik (opcjonalnie):</label>
            <input type="file" name="plik" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        <a href="ogloszenia.php" class="btn btn-secondary">Anuluj</a>
    </form>
</body>
</html>
