<?php
session_start();
define('INSTALL_MODE', true);

$config_file = __DIR__ . '/../includes/config.php';

switch ((int)($_GET['step'] ?? 0)) {

    // KROK 2: test połączenia → dopiero potem zapis configu
    case 2: {
        $host   = trim($_POST['db_host'] ?? '');
        $dbname = trim($_POST['db_name'] ?? '');
        $user   = trim($_POST['db_user'] ?? '');
        $pass   = $_POST['db_pass'] ?? '';
        $prefix = trim($_POST['prefix'] ?? '');

        try {
            // Test połączenia (bez użycia includes/db.php!)
            $dsn = "mysql:host={$host};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Utwórz bazę jeśli brak
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            $pdo->exec("USE `{$dbname}`");

        } catch (Throwable $e) {
            $_SESSION['installer_error'] = 'Błąd połączenia: ' . $e->getMessage();
            header('Location: install.php?step=1');
            exit;
        }

        // Jeśli test OK → zapisz config ATOMOWO
        $content = "<?php\nreturn [\n"
                 . "  'host' => " . var_export($host, true) . ",\n"
                 . "  'dbname' => " . var_export($dbname, true) . ",\n"
                 . "  'user' => " . var_export($user, true) . ",\n"
                 . "  'pass' => " . var_export($pass, true) . ",\n"
                 . "  'prefix' => " . var_export($prefix, true) . "\n"
                 . "];\n";

        $tmp = $config_file . '.tmp';
        file_put_contents($tmp, $content, LOCK_EX);
        rename($tmp, $config_file);

        $_SESSION['prefix'] = $prefix;
        header("Location: install.php?step=3");
        exit;
    }

    // KROK 3: tworzenie tabel (użyj połączenia z powyższych danych)
    case 3: {
        $cfg = include $config_file;
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset=utf8mb4";
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $prefix = $cfg['prefix'];
        include __DIR__ . '/sql/sql.php'; // $create = [ ... ]

        foreach ($create as $q) {
            $q = str_replace('{$prefix}', $prefix, $q);
            $pdo->exec($q);
        }

        header("Location: install.php?step=4");
        exit;
    }

    // KROK 4: seedy
    case 4: {
        $cfg = include $config_file;
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset=utf8mb4";
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $prefix = $cfg['prefix'];
        include __DIR__ . '/sql/insert.php'; // użyj $pdo + {$prefix} w zapytaniach

        header("Location: install.php?step=5");
        exit;
    }

    // KROK 6: zapis ustawień app + admin i flaga .installed
    case 6: {
        $cfg = include $config_file;
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset=utf8mb4";
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        if (($_POST['passwd'] ?? '') !== ($_POST['passwd2'] ?? '')) {
            echo "❌ Hasła się nie zgadzają. <a href='install.php?step=5'>Wróć</a>";
            exit;
        }

        // app-config (opcjonalnie)
        $appCfg = __DIR__ . '/../includes/app-config.php';
        $appContent = "<?php\nreturn [\n"
                    . "  'base_url' => " . var_export($_POST['base_url'] ?? '', true) . ",\n"
                    . "  'nazwa_aplikacji' => " . var_export($_POST['nazwa_aplikacji'] ?? '', true) . ",\n"
                    . "  'wersja' => " . var_export($_POST['wersja'] ?? '', true) . ",\n"
                    . "  'brand' => " . var_export($_POST['brand'] ?? '', true) . ",\n"
                    . "  'phone' => " . var_export($_POST['phone'] ?? '', true) . "\n"
                    . "];\n";
        file_put_contents($appCfg, $appContent, LOCK_EX);

        // admin
        $prefix = $cfg['prefix'];
        $email  = $_POST['admin_login'] ?? '';
        $hash   = password_hash($_POST['passwd'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO `{$prefix}uzytkownik` (imie, nazwisko, email, haslo, rola_id)
                               VALUES ('Admin', 'Główny', ?, ?, 2)");
        $stmt->execute([$email, $hash]);

        // znacznik udanej instalacji (nie wymagany, ale pomocny)
        file_put_contents(__DIR__ . '/../includes/.installed', date('c'));

        echo "<h2>✅ Instalacja zakończona!</h2><p><a href='../index.php'>Przejdź do aplikacji</a></p>";
        exit;
    }
}
