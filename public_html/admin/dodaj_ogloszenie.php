<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

$installerConfig = include '../install/config/config.php';
$prefix = $installerConfig['prefix'];

$blad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];
    $autor_id = $_SESSION['user_id'];
    $plik_nazwa = '';

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
        $stmt = $pdo->prepare("INSERT INTO `{$prefix}ogloszenie` (tytul, tresc, plik, autor_id, data_dodania) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$tytul, $tresc, $plik_nazwa, $autor_id]);
        header("Location: ogloszenia.php");
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
<body class="p-5">
    <h2 class="mb-4">Dodaj ogłoszenie</h2>

    <?php if ($blad): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($blad) ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tytuł:</label>
            <input type="text" name="tytul" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Treść:</label>
            <textarea name="tresc" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label>Plik (PDF lub HTML):</label>
            <input type="file" name="plik" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Dodaj ogłoszenie</button>
        <a href="ogloszenia.php" class="btn btn-secondary">Anuluj</a>
    </form>
</body>
</html>
