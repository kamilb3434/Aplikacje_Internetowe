<?php
session_start();
require_once '../includes/db.php';

// Załaduj prefix z configu
$config = include '../install/config/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'], $_GET['akcja'])) {
    header("Location: referaty.php");
    exit;
}

$id = (int)$_GET['id'];
$akcja = $_GET['akcja'];

if ($akcja === 'zaakceptuj') {
    $status = 'zaakceptowany';
} elseif ($akcja === 'odrzuc') {
    $status = 'odrzucony';
} else {
    header("Location: referaty.php");
    exit;
}

$stmt = $pdo->prepare("UPDATE {$prefix}referaty SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

header("Location: referaty.php");
exit;
?>
