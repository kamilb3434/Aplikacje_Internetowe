<?php
require_once 'includes/db.php';

// 🔄 Załaduj konfigurację z prefixem
$config = include 'includes/config.php';
$prefix = $config['prefix'];

// Funkcja pomocnicza do przekierowań z błędem
function redirect_with_error($msg) {
    header("Location: register.php?error=$msg");
    exit;
}

// ✅ Walidacja wymaganych danych
if (
    empty($_POST['firstName']) || 
    empty($_POST['lastName']) ||
    empty($_POST['email']) ||
    empty($_POST['password'])
) {
    redirect_with_error("puste_pola");
}

// 📥 Pobranie i przycięcie danych
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
$rola_id = 1; // domyślnie zwykły użytkownik

// 🛡️ Walidacja emaila
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with_error("niepoprawny_email");
}

// 🛡️ Hasło min. 8 znaków
// 🛡️ Zasady hasła: 8–72 znaków, min. 1 duża, 1 mała, 1 cyfra, 1 znak spec., bez spacji
$haslo_ok =
    strlen($haslo) >= 8 && strlen($haslo) <= 72 &&
    preg_match('/[A-Z]/', $haslo) &&        // min. 1 duża litera
    preg_match('/[a-z]/', $haslo) &&        // min. 1 mała litera
    preg_match('/\d/',    $haslo) &&        // min. 1 cyfra
    preg_match('/[^A-Za-z0-9]/', $haslo) && // min. 1 znak specjalny
    !preg_match('/\s/',   $haslo);          // bez spacji/whitespaces

if (!$haslo_ok) {
    redirect_with_error("haslo_slabe");
}

// 🛡️ Długość pól
if (strlen($imie) > 50 || strlen($nazwisko) > 50) {
    redirect_with_error("za_dlugi_tekst");
}
if (strlen($email) > 100) {
    redirect_with_error("email_za_dlugi");
}

// 🛡️ Kod pocztowy format
if (!empty($kod_pocztowy) && !preg_match('/^\d{2}-\d{3}$/', $kod_pocztowy)) {
    redirect_with_error("bledny_kod");
}

// ❌ Sprawdź czy email już istnieje
$stmt = $pdo->prepare("SELECT id FROM `{$prefix}uzytkownik` WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    redirect_with_error("email_zajety");
}

// 🔐 Haszowanie hasła
$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

// 📝 Zapis do bazy
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
