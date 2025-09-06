<?php
session_start();
require_once '../includes/db.php';

// Załaduj prefix
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

// Pobierz dane użytkownika
$stmt = $pdo->prepare("SELECT * FROM {$prefix}uzytkownik WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Nie znaleziono użytkownika.";
    exit;
}

$komunikat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $adres_kod = $_POST['adres_kod_pocztowy'];
    $adres_miejscowosc = $_POST['adres_miejscowosc'];
    $adres_ulica = $_POST['adres_ulica'];
    $adres_nr_domu = $_POST['adres_nr_domu'];
    $adres_nr_lokalu = $_POST['adres_nr_lokalu'];
    $data_urodzenia = $_POST['data_urodzenia'];

    // aktualizacja danych
    $stmt = $pdo->prepare("UPDATE {$prefix}uzytkownik SET imie = ?, nazwisko = ?, email = ?, adres_kod_pocztowy = ?, adres_miejscowosc = ?, adres_ulica = ?, adres_nr_domu = ?, adres_nr_lokalu = ?, data_urodzenia = ? WHERE id = ?");
    $stmt->execute([$imie, $nazwisko, $email, $adres_kod, $adres_miejscowosc, $adres_ulica, $adres_nr_domu, $adres_nr_lokalu, $data_urodzenia, $id]);

    // aktualizacja hasła jeśli podane
    if (!empty($_POST['haslo'])) {
        if ($_POST['haslo'] !== $_POST['haslo2']) {
            $komunikat = "<div class='alert alert-danger'>Hasła się nie zgadzają!</div>";
        } else {
            $stmt = $pdo->prepare("SELECT haslo FROM {$prefix}uzytkownik WHERE id = ?");
            $stmt->execute([$id]);
            $oldHash = $stmt->fetchColumn();

            if (password_verify($_POST['haslo'], $oldHash)) {
                $komunikat = "<div class='alert alert-warning text-center'>Nowe hasło nie może być takie samo jak obecne.</div>";
            } else {
                $hashedPassword = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE {$prefix}uzytkownik SET haslo = ? WHERE id = ?");
                $stmt->execute([$hashedPassword, $id]);
                $komunikat = "<div class='alert alert-success'>Dane użytkownika i hasło zostały zaktualizowane.</div>";
            }
        }
    } else {
        $komunikat = "<div class='alert alert-success'>Dane użytkownika zostały zaktualizowane.</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj użytkownika</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Edytuj dane użytkownika</h2>

    <?= $komunikat ?>

    <form method="post" id="editForm">
        <div class="form-group">
            <label>Imię</label>
            <input type="text" name="imie" class="form-control" value="<?= htmlspecialchars($user['imie']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nazwisko</label>
            <input type="text" name="nazwisko" class="form-control" value="<?= htmlspecialchars($user['nazwisko']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Data urodzenia</label>
            <input type="date" name="data_urodzenia" class="form-control" value="<?= $user['data_urodzenia'] ?>">
        </div>
        <div class="form-group">
            <label>Kod pocztowy</label>
            <input type="text" name="adres_kod_pocztowy" class="form-control" value="<?= htmlspecialchars($user['adres_kod_pocztowy']) ?>">
        </div>
        <div class="form-group">
            <label>Miejscowość</label>
            <input type="text" name="adres_miejscowosc" class="form-control" value="<?= htmlspecialchars($user['adres_miejscowosc']) ?>">
        </div>
        <div class="form-group">
            <label>Ulica</label>
            <input type="text" name="adres_ulica" class="form-control" value="<?= htmlspecialchars($user['adres_ulica']) ?>">
        </div>
        <div class="form-group">
            <label>Nr domu</label>
            <input type="text" name="adres_nr_domu" class="form-control" value="<?= htmlspecialchars($user['adres_nr_domu']) ?>">
        </div>
        <div class="form-group">
            <label>Nr lokalu</label>
            <input type="text" name="adres_nr_lokalu" class="form-control" value="<?= htmlspecialchars($user['adres_nr_lokalu']) ?>">
        </div>

        <hr>
        <div class="form-group">
            <label>Nowe hasło (opcjonalnie)</label>
            <input type="password" name="haslo" id="haslo" class="form-control">
        </div>
        <div class="form-group">
            <label>Powtórz nowe hasło</label>
            <input type="password" name="haslo2" id="haslo2" class="form-control">
            <small id="passwordHelp" class="form-text text-danger d-none">Hasła muszą być takie same.</small>
        </div>

        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        <a href="uzytkownicy.php" class="btn btn-secondary ml-2">Anuluj</a>
    </form>
</div>

<script>
document.getElementById("editForm").addEventListener("submit", function(e) {
    const haslo = document.getElementById("haslo").value;
    const haslo2 = document.getElementById("haslo2").value;
    const alert = document.getElementById("passwordHelp");

    if (haslo || haslo2) {
        if (haslo !== haslo2) {
            alert.classList.remove("d-none");
            e.preventDefault();
        } else {
            alert.classList.add("d-none");
        }
    }
});
</script>
</body>
</html>
