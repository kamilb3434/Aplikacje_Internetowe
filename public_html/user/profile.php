<?php

session_start();
require_once '../includes/db.php';

// Wczytaj prefix z configu
$config = include '../includes/config.php';
$prefix = $config['prefix'];

if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM `{$prefix}uzytkownik` WHERE id = ?";
$stmt = $pdo->prepare($sql);
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
    <title>Profil użytkownika</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="userDashboard.php">Panel użytkownika</a>
        <a href="../logout.php" class="btn btn-outline-light">Wyloguj</a>
    </div>
</nav>

<main class="container mt-5 flex-grow-1">
    <h2 class="mb-4">Edytuj swoje dane</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success">Dane zostały zaktualizowane.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert alert-danger">Wystąpił błąd podczas aktualizacji danych.</div>
    <?php endif; ?>

    <form action="profile_update.php" method="post" class="row g-3">
        <div class="col-md-6">
            <label for="imie" class="form-label">Imię</label>
            <input type="text" class="form-control" id="imie" name="imie" value="<?php echo htmlspecialchars($user['imie']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="nazwisko" class="form-label">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" value="<?php echo htmlspecialchars($user['nazwisko']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="col-md-6">
            <label for="data_urodzenia" class="form-label">Data urodzenia</label>
            <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" value="<?php echo $user['data_urodzenia']; ?>">
        </div>

        <div class="col-md-4">
            <label for="kod_pocztowy" class="form-label">Kod pocztowy</label>
            <input type="text" class="form-control" id="kod_pocztowy" name="kod_pocztowy" value="<?php echo htmlspecialchars($user['adres_kod_pocztowy']); ?>">
        </div>

        <div class="col-md-4">
            <label for="miejscowosc" class="form-label">Miejscowość</label>
            <input type="text" class="form-control" id="miejscowosc" name="miejscowosc" value="<?php echo htmlspecialchars($user['adres_miejscowosc']); ?>">
        </div>

        <div class="col-md-4">
            <label for="ulica" class="form-label">Ulica</label>
            <input type="text" class="form-control" id="ulica" name="ulica" value="<?php echo htmlspecialchars($user['adres_ulica']); ?>">
        </div>

        <div class="col-md-6">
            <label for="nr_domu" class="form-label">Nr domu</label>
            <input type="text" class="form-control" id="nr_domu" name="nr_domu" value="<?php echo htmlspecialchars($user['adres_nr_domu']); ?>">
        </div>

        <div class="col-md-6">
            <label for="nr_mieszkania" class="form-label">Nr lokalu</label>
            <input type="text" class="form-control" id="nr_mieszkania" name="nr_mieszkania" value="<?php echo htmlspecialchars($user['adres_nr_lokalu']); ?>">
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </form>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">&copy; Serwis konferencyjny 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
