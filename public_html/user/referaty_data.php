<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/db.php';
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT r.tytul, rs.nazwa_statusu, r.data_zgloszenia
    FROM `{$prefix}referat` r
    JOIN `{$prefix}referat_status` rs ON r.status_id = rs.id
    WHERE r.uczestnik_id = ?
    ORDER BY r.data_zgloszenia DESC
");
$stmt->execute([$userId]);
$referaty = $stmt->fetchAll();

