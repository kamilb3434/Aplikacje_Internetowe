<?php
session_start();

// Ładujemy dane konfiguracyjne
$config = include 'includes/config.php';
$prefix = $config['prefix'];

// Połączenie z bazą (jeśli nie masz globalnie w db.php)
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$email = $_POST['email'] ?? '';
$haslo = $_POST['password'] ?? '';

$sql = "SELECT * FROM `{$prefix}uzytkownik` WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch();

if ($user && password_verify($haslo, $user['haslo'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['imie'] = $user['imie'];
    $_SESSION['nazwisko'] = $user['nazwisko'];
    $_SESSION['rola_id'] = $user['rola_id'];

    if ($user['rola_id'] == 2) {
        header("Location: ../admin/adminDashboard.php");
    } else {
        header("Location: ../user/userDashboard.php");
    }
    exit;
} else {
    header("Location: ../login.php?error=1");
    exit;
}
