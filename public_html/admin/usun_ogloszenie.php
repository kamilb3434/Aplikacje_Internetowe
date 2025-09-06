<?php
session_start();
if (!isset($_SESSION['user_id']) || (int)$_SESSION['rola_id'] !== 2) { header("Location: ../login.php"); exit; }

$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: ogloszenia.php?err=badid'); exit; }

$stmt = $pdo->prepare("SELECT plik FROM `{$prefix}ogloszenie` WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $pdo->prepare("DELETE FROM `{$prefix}ogloszenie` WHERE id = ?")->execute([$id]);
    if (!empty($row['plik'])) {
        $path = __DIR__ . '/../uploads/ogloszenia/' . basename($row['plik']);
        if (is_file($path)) { @unlink($path); }
    }
}
header('Location: ogloszenia.php?deleted=1'); exit;
