<?php
require_once 'includes/db.php';

$config = include 'includes/config.php';
$prefix = $config['prefix'];

function redirect_with_error($msg) {
    header("Location: register.php?error=$msg");
    exit;
}

if (
    empty($_POST['firstName']) || 
    empty($_POST['lastName']) ||
    empty($_POST['email']) ||
    empty($_POST['password'])
) {
    redirect_with_error("puste_pola");
}

$imie = trim($_POST['firstName']);
$nazwisko = trim($_POST['lastName']);
$email = trim($_POST['email']);
$haslo = $_POST['password'];
$data_urodzenia = $_POST['birthDate'] ?? null;
$kod_pocztowy = $_POST['postalCode'] ?? null;
$miejscowosc = $_POST['city'] ?? null;
$ulica = $_POST['street'] ?? null;
$nr_domu = $_POST['streetNumber'] ?? null;
$nr_lokalu = $_POST['apartmentNumber'] ?? null;
$rola_id = 1; 

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with_error("niepoprawny_email");
}

$haslo_ok =
    strlen($haslo) >= 8 && strlen($haslo) <= 72 &&
    preg_match('/[A-Z]/', $haslo) &&        
    preg_match('/[a-z]/', $haslo) &&        
    preg_match('/\d/',    $haslo) &&        
    preg_match('/[^A-Za-z0-9]/', $haslo) && 
    !preg_match('/\s/',   $haslo);          

if (!$haslo_ok) {
    redirect_with_error("haslo_slabe");
}

if (strlen($imie) > 50 || strlen($nazwisko) > 50) {
    redirect_with_error("za_dlugi_tekst");
}
if (strlen($email) > 100) {
    redirect_with_error("email_za_dlugi");
}

if (!empty($kod_pocztowy) && !preg_match('/^\d{2}-\d{3}$/', $kod_pocztowy)) {
    redirect_with_error("bledny_kod");
}

$stmt = $pdo->prepare("SELECT id FROM `{$prefix}uzytkownik` WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    redirect_with_error("email_zajety");
}

$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

$sql = "INSERT INTO `{$prefix}uzytkownik` (
    imie, nazwisko, email, haslo, data_urodzenia,
    adres_kod_pocztowy, adres_miejscowosc, adres_ulica,
    adres_nr_domu, adres_nr_lokalu, rola_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $imie,
        $nazwisko,
        $email,
        $haslo_hash,
        $data_urodzenia ?: null,
        $kod_pocztowy ?: null,
        $miejscowosc ?: null,
        $ulica ?: null,
        $nr_domu ?: null,
        $nr_lokalu ?: null,
        $rola_id
    ]);

    header("Location: login.php?success=1");
    exit;

} catch (PDOException $e) {
    redirect_with_error("blad_bazy");
}
