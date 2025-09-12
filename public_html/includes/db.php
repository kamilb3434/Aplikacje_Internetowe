<?php
// includes/db.php
// Jeden punkt tworzenia PDO + bezpieczny fallback do instalatora.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jeśli jesteśmy w instalatorze, NIE ładujemy połączenia i NIE robimy redirectu.
if (defined('INSTALL_MODE')) {
    return;
}

$configFile = __DIR__ . '/config.php';
if (!is_file($configFile)) {
    // Brak configa → do instalatora
    header('Location: /install/install.php?err=noconfig');
    exit;
}

$config = include $configFile;
if (!is_array($config) || !isset($config['host'], $config['dbname'], $config['user'], $config['pass'], $config['prefix'])) {
    $_SESSION['installer_error'] = 'Plik config.php jest niepoprawny.';
    header('Location: /install/install.php?err=badconfig');
    exit;
}

$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

try {
    $pdo = new PDO(
        $dsn,
        $config['user'],
        $config['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Jeśli jesteśmy w zwykłej aplikacji (nie CLI i nie instalator) → wróć do instalatora
    if (PHP_SAPI !== 'cli' && (stripos($_SERVER['SCRIPT_NAME'] ?? '', '/install/') === false)) {
        $_SESSION['installer_error'] = 'Nie można połączyć z bazą: ' . $e->getMessage();
        header('Location: /install/install.php?err=db');
        exit;
    }
    // W CLI lub w trakcie instalacji przekaż błąd dalej
    throw $e;
}
