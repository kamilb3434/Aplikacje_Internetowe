<?php
session_start();
require_once '../includes/db.php';
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = $_POST['tytul'] ?? '';
    $streszczenie = $_POST['streszczenie'] ?? '';
    $uczestnik_id = $_SESSION['user_id'];
    $plik_nazwa = '';

    // Obsługa pliku (jeśli dodany)
    if (!empty($_FILES['plik']['name'])) {
        $rozszerzenie = pathinfo($_FILES['plik']['name'], PATHINFO_EXTENSION);
        if (strtolower($rozszerzenie) === 'pdf') {
            $plik_nazwa = time() . '_' . basename($_FILES['plik']['name']);
            move_uploaded_file($_FILES['plik']['tmp_name'], '../pliki/' . $plik_nazwa);
        } else {
            die("Dozwolony tylko plik PDF.");
        }
    }

    // Zapis do bazy z prefixem
    $sql = "INSERT INTO `{$prefix}referaty` (tytul, streszczenie, plik, uczestnik_id, status) 
            VALUES (?, ?, ?, ?, 'oczekujący')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tytul, $streszczenie, $plik_nazwa, $uczestnik_id]);

    header("Location: zglos_referat.php?sukces=1");
    exit;
}
?>
