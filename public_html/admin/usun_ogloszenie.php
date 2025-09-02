<?php
session_start();
require_once '../includes/db.php';

// Wczytaj prefix z configu
$installerConfig = include '../install/config/config.php';
$prefix = $installerConfig['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ogloszenia.php");
    exit;
}

$id = (int) $_GET['id'];

// Pobierz plik do usunięcia (jeśli istnieje)
$stmt = $pdo->prepare("SELECT plik FROM `{$prefix}ogloszenie` WHERE id = ?");
$stmt->execute([$id]);
$ogloszenie = $stmt->fetch();

if ($ogloszenie) {
    // Usuń plik z dysku, jeśli istnieje
    if (!empty($ogloszenie['plik']) && file_exists('pliki/' . $ogloszenie['plik'])) {
        unlink('pliki/' . $ogloszenie['plik']);
    }

    // Usuń ogłoszenie z bazy
    $stmt = $pdo->prepare("DELETE FROM `{$prefix}ogloszenie` WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ogloszenia.php");
exit;
