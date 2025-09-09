<?php
session_start();
if (!isset($_SESSION['user_id']) || (int)$_SESSION['rola_id'] !== 1) {
    header("Location: ../login.php");
    exit;
}

$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $tytul        = trim($_POST['tytul'] ?? '');
    $streszczenie = trim($_POST['streszczenie'] ?? '');
    $uczestnik_id = (int)$_SESSION['user_id'];

    if ($tytul === '' || $streszczenie === '') {
        die('Brak wymaganych danych (tytuł / streszczenie).');
    }

    $plik_nazwa = null; 

    if (!empty($_FILES['plik']['name'])) {
        if (!isset($_FILES['plik']['error']) || $_FILES['plik']['error'] !== UPLOAD_ERR_OK) {
            die('Błąd przesyłania pliku.');
        }

        $ext = strtolower(pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            die('Dozwolony tylko plik PDF.');
        }

        $uploadDir = __DIR__ . '/../pliki_referatow';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                die('Nie udało się utworzyć katalogu na pliki.');
            }
        }

        $baseName   = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['plik']['name']));
        $plik_nazwa = time() . '_' . $baseName;
        $fullPath   = $uploadDir . DIRECTORY_SEPARATOR . $plik_nazwa;

        if (!move_uploaded_file($_FILES['plik']['tmp_name'], $fullPath)) {
            die('Nie udało się zapisać pliku na serwerze.');
        }
    }

    $sql = "INSERT INTO `{$prefix}referaty`
            (tytul, streszczenie, plik, uczestnik_id, data_zgloszenia, status)
            VALUES (?, ?, ?, ?, NOW(), 'oczekujący')";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tytul, $streszczenie, $plik_nazwa, $uczestnik_id]);
    } catch (PDOException $e) {
        if (!empty($plik_nazwa)) {
            @unlink(__DIR__ . '/../pliki_referatow/' . $plik_nazwa);
        }
        die('Błąd bazy: ' . htmlspecialchars($e->getMessage()));
    }

    header("Location: zglos_referat.php?sukces=1");
    exit;
}
