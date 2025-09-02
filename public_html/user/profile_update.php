<?php
session_start();
require_once '../includes/db.php';

// Pobierz prefix z configu
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];

// Pobierz dane z formularza
$imie = $_POST['imie'] ?? '';
$nazwisko = $_POST['nazwisko'] ?? '';
$email = $_POST['email'] ?? '';
$data_urodzenia = $_POST['data_urodzenia'] ?? null;
$kod_pocztowy = $_POST['kod_pocztowy'] ?? '';
$miejscowosc = $_POST['miejscowosc'] ?? '';
$ulica = $_POST['ulica'] ?? '';
$nr_domu = $_POST['nr_domu'] ?? '';
$nr_mieszkania = $_POST['nr_mieszkania'] ?? '';

// Użyj prefixu w zapytaniu
$sql = "UPDATE `{$prefix}uzytkownik` SET 
    imie = ?, 
    nazwisko = ?, 
    email = ?, 
    data_urodzenia = ?, 
    adres_kod_pocztowy = ?, 
    adres_miejscowosc = ?, 
    adres_ulica = ?, 
    adres_nr_domu = ?, 
    adres_nr_lokalu = ?
    WHERE id = ?";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    $imie,
    $nazwisko,
    $email,
    $data_urodzenia,
    $kod_pocztowy,
    $miejscowosc,
    $ulica,
    $nr_domu,
    $nr_mieszkania,
    $id
]);

// Po aktualizacji – przekierowanie z info
if ($result) {
    header("Location: profile.php?status=success");
} else {
    header("Location: profile.php?status=error");
}
exit;
