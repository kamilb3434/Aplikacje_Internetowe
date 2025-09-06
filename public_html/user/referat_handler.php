<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = trim($_POST['tytul'] ?? '');
    $streszczenie = trim($_POST['streszczenie'] ?? '');
    $uczestnik_id = (int)$_SESSION['user_id'];
    $plik_nazwa = null;

    // katalog docelowy dla referatów (spójny w całym projekcie)
    $uploadDir = __DIR__ . '/../pliki_referatow/';
    if (!is_dir($uploadDir)) {
        // utwórz jeśli brakuje
        if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            die('Nie mogę utworzyć katalogu na pliki.');
        }
    }

    // Obsługa pliku (jeśli dodany)
    if (!empty($_FILES['plik']['name']) && $_FILES['plik']['error'] === UPLOAD_ERR_OK) {
        $rozszerzenie = strtolower(pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION));
        if ($rozszerzenie !== 'pdf') {
            die("Dozwolony tylko plik PDF.");
        }

        // bezpieczna i unikalna nazwa
        $oryg = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES['plik']['name']));
        $plik_nazwa = time() . '_' . $oryg;

        $ok = move_uploaded_file($_FILES['plik']['tmp_name'], $uploadDir . $plik_nazwa);
        if (!$ok) {
            die('Nie udało się zapisać pliku na serwerze.');
        }
    }

    // Zapis do bazy (w kolumnie `plik` przechowujemy tylko samą nazwę)
    $sql = "INSERT INTO `{$prefix}referaty`
            (tytul, streszczenie, plik, uczestnik_id, data_zgloszenia, status)
            VALUES (?, ?, ?, ?, NOW(), 'oczekujący')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tytul, $streszczenie, $plik_nazwa, $uczestnik_id]);

    header("Location: zglos_referat.php?sukces=1");
    exit;
}
