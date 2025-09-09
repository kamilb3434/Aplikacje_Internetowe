<?php
// public_html/download_ogloszenie.php
session_start();

// jeśli ogłoszenia mają być dostępne tylko po zalogowaniu – zostaw;
// jeśli mają być publiczne, usuń ten blok
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/includes/db.php';
$config = include __DIR__ . '/includes/config.php';
$prefix = $config['prefix'];

$id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$force = (isset($_GET['dl']) && $_GET['dl'] === '1');

if ($id <= 0) {
    http_response_code(400);
    exit('Błędne ID.');
}

// pobierz nazwę pliku dla ogłoszenia
$stmt = $pdo->prepare("SELECT plik FROM `{$prefix}ogloszenie` WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || $row['plik'] === null || $row['plik'] === '') {
    http_response_code(404);
    exit('Nie znaleziono pliku.');
}

// ścieżka do katalogu uploadów
$baseDir  = realpath(__DIR__ . '/uploads/ogloszenia');
$fileName = basename($row['plik']); // sanity check
$fullPath = ($baseDir !== false) ? realpath($baseDir . DIRECTORY_SEPARATOR . $fileName) : false;

// weryfikacje bezpieczeństwa i istnienia
if ($baseDir === false || $fullPath === false || strpos($fullPath, $baseDir) !== 0 || !is_file($fullPath)) {
    http_response_code(404);
    exit('Plik nie istnieje.');
}

// wykryj MIME (PDF/HTML)
$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
$mime  = $finfo ? finfo_file($finfo, $fullPath) : null;
if ($finfo) { finfo_close($finfo); }

// domyślnie PDF, ale pozwól na HTML
if (!$mime) {
    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    $mime = ($ext === 'html' || $ext === 'htm') ? 'text/html; charset=UTF-8' : 'application/pdf';
}

$disp = $force ? 'attachment' : 'inline';

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
header('Content-Length: ' . filesize($fullPath));
header("Content-Disposition: {$disp}; filename*=UTF-8''" . rawurlencode($fileName));

readfile($fullPath);
exit;
