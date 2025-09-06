<?php
// public_html/download_referat.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/includes/db.php';   // ustawia $pdo i $config
$prefix = $config['prefix'];

$refId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$forceDownload = isset($_GET['dl']) && $_GET['dl'] == '1';

if ($refId <= 0) {
    http_response_code(400);
    exit('Błędne ID.');
}

// 1) Pobierz plik i właściciela
$stmt = $pdo->prepare("SELECT id, plik, uczestnik_id, status FROM `{$prefix}referaty` WHERE id = ? LIMIT 1");
$stmt->execute([$refId]);
$row = $stmt->fetch();

if (!$row || empty($row['plik'])) {
    http_response_code(404);
    exit('Nie znaleziono pliku.');
}

// 2) Autoryzacja:
// - admin (rola_id=2) ma dostęp
// - właściciel referatu ma dostęp
// (opcjonalnie: dopuść wszystkich do 'zaakceptowany' → odkomentuj warunek)
$isAdmin = isset($_SESSION['rola_id']) && (int)$_SESSION['rola_id'] === 2;
$isOwner = (int)$row['uczestnik_id'] === (int)$_SESSION['user_id'];
// $isPublicAccepted = ($row['status'] === 'zaakceptowany');

if (!($isAdmin || $isOwner /* || $isPublicAccepted */)) {
    http_response_code(403);
    exit('Brak uprawnień.');
}

// 3) Zbuduj ścieżkę do pliku (katalog z plikami referatów)
$baseDir  = realpath(__DIR__ . '/pliki_referatow');
$fileName = basename($row['plik']); // sanity check
$fullPath = $baseDir !== false ? realpath($baseDir . DIRECTORY_SEPARATOR . $fileName) : false;

// 4) Walidacje bezpieczeństwa
if ($baseDir === false || $fullPath === false || strpos($fullPath, $baseDir) !== 0 || !is_file($fullPath)) {
    http_response_code(404);
    exit('Plik nie istnieje.');
}

// 5) MIME + nagłówki
$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
$mime  = $finfo ? finfo_file($finfo, $fullPath) : null;
if ($finfo) { finfo_close($finfo); }

// Domyślnie PDF; jeżeli coś innego, wyślij octet-stream
if (!$mime || !preg_match('#^application/pdf#i', $mime)) {
    $mime = 'application/pdf';
}

$disp = $forceDownload ? 'attachment' : 'inline';
$downloadName = $fileName; // możesz tu podstawić oryginalną nazwę, jeśli ją przechowujesz osobno

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
header('Content-Length: ' . filesize($fullPath));
header("Content-Disposition: {$disp}; filename*=UTF-8''" . rawurlencode($downloadName));

readfile($fullPath);
exit;
