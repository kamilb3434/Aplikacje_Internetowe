<?php
// public_html/install/install.php
session_start();

$configPath = __DIR__ . '/../includes/config.php';

// Krok z URL (domyślnie 1)
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Utwórz pusty config, jeżeli nie istnieje (schemat: "Utwórz plik config.php (touch config.php)")
if (!is_file($configPath)) {
    // spróbuj utworzyć (z prawami 0644)
    @file_put_contents($configPath, "<?php\nreturn [\n// będzie uzupełnione w kroku 2\n];\n");
}

// Sprawdź zapisywalność pliku przed krokiem 2
$configWritable = is_writable($configPath);

// Błędy/info z sesji
$err  = $_SESSION['installer_error']  ?? null;
$old  = $_SESSION['installer_old']    ?? [
    'db_host' => '127.0.0.1',
    'db_name' => 'serwiskonf',
    'db_user' => 'root',
    'prefix'  => 'serwiskonf_',
];

// po odczycie wyczyść (żeby nie wisiało)
unset($_SESSION['installer_error'], $_SESSION['installer_old']);

?><!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Instalator – Serwis konferencyjny</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>body{padding:30px;background:#f7f7f7}</style>
</head>
<body>
<div class="container">
  <h1 class="mb-4">🛠 Instalator</h1>

  <?php if (!$configWritable): ?>
    <div class="alert alert-danger">
      Plik <code>includes/config.php</code> nie jest zapisywalny.<br>
      Ustaw uprawnienia (np. <code>chmod 644</code> lub tymczasowo <code>664</code>) albo nadaj właściciela serwerowi www.
      Następnie odśwież stronę i kontynuuj.
    </div>
  <?php endif; ?>

  <?php
  switch ($step) {
      case 1:
          // Formularz DB (Krok 1 w schemacie)
          include __DIR__ . '/steps/step1.php';
          break;

      case 3:
          // Po kroku 2 handler przenosi tu: tworzenie struktury (robi handler)
          echo '<div class="alert alert-info">Trwa tworzenie bazy danych…</div>';
          echo '<p>Jeśli nic się nie dzieje, <a href="install-handler.php?step=3">kliknij tutaj</a>.</p>';
          break;

      case 4:
          echo '<div class="alert alert-info">Trwa dodawanie danych startowych…</div>';
          echo '<p>Jeśli nic się nie dzieje, <a href="install-handler.php?step=4">kliknij tutaj</a>.</p>';
          break;

      case 5:
          // Formularz aplikacji + admin (Krok 5 w schemacie)
          include __DIR__ . '/steps/step5.php';
          break;

      case 6:
          echo '<div class="alert alert-info">Finalizacja…</div>';
          echo '<p>Jeśli nic się nie dzieje, <a href="install-handler.php?step=6">kliknij tutaj</a>.</p>';
          break;

      default:
          echo '<div class="alert alert-warning">Nieznany krok.</div>';
          echo '<a class="btn btn-secondary" href="install.php?step=1">Wróć do kroku 1</a>';
  }
  ?>
</div>
</body>
</html>
