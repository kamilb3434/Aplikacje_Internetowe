<?php
session_start();
require_once '../includes/db.php';

// Wczytanie prefixu z configu
$installerConfig = include '../includes/config.php';
$prefix = $installerConfig['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['akcja'])) {
    $id = (int)$_GET['id'];
    $akcja = $_GET['akcja'];

    if ($akcja === 'dezaktywuj') {
        $stmt = $pdo->prepare("UPDATE `{$prefix}uzytkownik` SET status = 0 WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($akcja === 'aktywuj') {
        $stmt = $pdo->prepare("UPDATE `{$prefix}uzytkownik` SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: uzytkownicy.php");
    exit;
} else {
    header("Location: uzytkownicy.php?error=invalid_request");
    exit;
}

