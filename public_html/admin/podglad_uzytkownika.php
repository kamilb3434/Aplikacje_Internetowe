<?php
session_start();
require_once '../includes/db.php';

// Pobierz prefix
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: uzytkownicy.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM {$prefix}uzytkownik WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Nie znaleziono użytkownika.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Podgląd użytkownika</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Szczegóły użytkownika</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $user['id'] ?></td></tr>
        <tr><th>Imię</th><td><?= htmlspecialchars($user['imie']) ?></td></tr>
        <tr><th>Nazwisko</th><td><?= htmlspecialchars($user['nazwisko']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><th>Data urodzenia</th><td><?= htmlspecialchars($user['data_urodzenia']) ?></td></tr>
        <tr><th>Kod pocztowy</th><td><?= htmlspecialchars($user['adres_kod_pocztowy']) ?></td></tr>
        <tr><th>Miejscowość</th><td><?= htmlspecialchars($user['adres_miejscowosc']) ?></td></tr>
        <tr><th>Ulica</th><td><?= htmlspecialchars($user['adres_ulica']) ?></td></tr>
        <tr><th>Numer domu</th><td><?= htmlspecialchars($user['adres_nr_domu']) ?></td></tr>
        <tr><th>Numer lokalu</th><td><?= htmlspecialchars($user['adres_nr_lokalu']) ?></td></tr>
        <tr><th>Rola</th><td><?= $user['rola_id'] == 1 ? 'Użytkownik' : 'Administrator' ?></td></tr>
        <tr><th>Data rejestracji</th><td><?= $user['data_rejestracji'] ?></td></tr>
        <tr><th>Status</th>
            <td><?= $user['status'] == 1 ? '<span class="badge badge-success">Aktywny</span>' : '<span class="badge badge-secondary">Nieaktywny</span>' ?></td>
        </tr>
    </table>
    <a href="uzytkownicy.php" class="btn btn-secondary mt-3">Powrót</a>
</div>
</body>
</html>
