<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /login.php'); exit; }

require_once __DIR__ . '/includes/db.php';
$config = include __DIR__ . '/includes/config.php';
$prefix = $config['prefix'];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$force = (isset($_GET['dl']) && $_GET['dl'] == '1');

if ($id <= 0) { http_response_code(400); exit('Błędne ID.'); }

$stmt = $pdo->prepare("SELECT plik FROM `{$prefix}ogloszenie` WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || empty($row['plik'])) { http_response_code(404); exit('Nie znaleziono pliku.'); }

$baseDir = realpath(__DIR__ . '/uploads/ogloszenia');
$fileName = basename($row['plik']);
$fullPath = ($baseDir !== false) ? realpath($baseDir . DIRECTORY_SEPARATOR . $fileName) : false;

if ($baseDir === false || $fullPath === false || strpos($fullPath, $baseDir) !== 0 || !is_file($fullPath)) {
    http_response_code(404); exit('Plik nie istnieje.');
}

$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
$mime  = $finfo ? finfo_file($finfo, $fullPath) : null; if ($finfo) finfo_close($finfo);
if (!$mime || !preg_match('#^application/pdf#i', $mime)) { $mime = 'application/pdf'; }

$disp = $force ? 'attachment' : 'inline';
header('Content-Type: '.$mime);
header('X-Content-Type-Options: nosniff');
header('Content-Length: '.filesize($fullPath));
header("Content-Disposition: {$disp}; filename*=UTF-8''".rawurlencode($fileName));
readfile($fullPath);
exit;
