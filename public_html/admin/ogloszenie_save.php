<?php
session_start();
if (!isset($_SESSION['user_id']) || (int)$_SESSION['rola_id'] !== 2) { header("Location: ../login.php"); exit; }

$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];
require_once __DIR__ . '/../includes/db.php';

$tytul = trim($_POST['tytul'] ?? '');
$tresc = trim($_POST['tresc'] ?? '');
$autor_id = (int)$_SESSION['user_id'];
$plik_nazwa = null;

if ($tytul === '') { header("Location: dodaj_ogloszenie.php?error=brak_tytulu"); exit; }

// upload (opcjonalny)
if (!empty($_FILES['plik']['name']) && $_FILES['plik']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') { die('Dozwolony tylko PDF.'); }

    $uploadDir = __DIR__ . '/../uploads/ogloszenia';
    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0775, true); }

    $safeBase = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['plik']['name']));
    $plik_nazwa = time() . '_' . $safeBase;
    $fullPath = $uploadDir . DIRECTORY_SEPARATOR . $plik_nazwa;

    if (!move_uploaded_file($_FILES['plik']['tmp_name'], $fullPath)) {
        die('Nie udało się zapisać pliku na serwerze.');
    }
}

$sql = "INSERT INTO `{$prefix}ogloszenie` (tytul, tresc, plik, data_dodania, autor_id)
        VALUES (?, ?, ?, NOW(), ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$tytul, $tresc, $plik_nazwa, $autor_id]);

header("Location: ogloszenia.php?ok=1"); exit;
