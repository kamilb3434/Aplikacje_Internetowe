<?php
session_start();

$config_file = __DIR__ . '/../includes/config.php';


// Tworzymy katalog config jeśli nie istnieje
//if (!is_dir(__DIR__ . '/config')) {
//    mkdir(__DIR__ . '/config', 0775, true);
//}


switch ($_GET['step']) {

    // Krok 2: zapisujemy dane z formularza do config.php
    case 2:
        $content = "<?php\nreturn [\n";
        $content .= "'host' => '{$_POST['db_host']}',\n";
        $content .= "'dbname' => '{$_POST['db_name']}',\n";
        $content .= "'user' => '{$_POST['db_user']}',\n";
        $content .= "'pass' => '{$_POST['db_pass']}',\n";
        $content .= "'prefix' => '{$_POST['prefix']}'\n";
        $content .= "];\n";

        file_put_contents($config_file, $content);

        $_SESSION['prefix'] = $_POST['prefix'];
        header("Location: install.php?step=3");
        break;

    // Krok 3: tworzymy bazę danych i tabele
    case 3:
        $config = include($config_file);
        $conn = mysqli_connect($config['host'], $config['user'], $config['pass']);
        if (!$conn) die("Błąd połączenia z MySQL: " . mysqli_connect_error());

        mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$config['dbname']}`");
        mysqli_select_db($conn, $config['dbname']);

        $prefix = $config['prefix'];
        include 'sql/sql.php'; // plik powinien zawierać tablicę $create

        foreach ($create as $q) {
            $q = str_replace('{$prefix}', $prefix, $q);
            mysqli_query($conn, $q);
        }

        header("Location: install.php?step=4");
        break;

    // Krok 4: insert danych startowych
    case 4:
        $config = include($config_file);
        $conn = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['dbname']);
        if (!$conn) die("Błąd połączenia z MySQL: " . mysqli_connect_error());

        $prefix = $config['prefix'];
        include 'sql/insert.php';

        /*foreach ($insert as $q) {
            $q = "INSERT IGNORE INTO `{$prefix}uzytkownik` 
            (`imie`, `nazwisko`, `email`, `haslo`, `rola_id`) 
            VALUES ('Admin', 'Główny', '$email', '$hashed', 2)";
        } */

        include 'sql/insert.php';

        header("Location: install.php?step=5");
        break;

    // Krok 6: tworzymy konto administratora i zapisujemy dane aplikacji
    case 6:
        $config = include($config_file);

        if ($_POST['passwd'] !== $_POST['passwd2']) {
            echo "❌ Hasła się nie zgadzają. <a href='install.php?step=5'>Wróć</a>";
            exit;
        }

        /*
        // Dopisanie danych aplikacji na końcu pliku konfiguracyjnego
        $append = "\n// Dane aplikacji\n";
        $append .= "\$base_url = '{$_POST['base_url']}';\n";
        $append .= "\$nazwa_aplikacji = '{$_POST['nazwa_aplikacji']}';\n";
        $append .= "\$wersja = '{$_POST['wersja']}';\n";
        $append .= "\$brand = '{$_POST['brand']}';\n";
        $append .= "\$phone = '{$_POST['phone']}';\n";
        file_put_contents($config_file, $append, FILE_APPEND);
        */

        

        $appConfig = "<?php\nreturn [\n";
        $appConfig .= "'base_url' => '{$_POST['base_url']}',\n";
        $appConfig .= "'nazwa_aplikacji' => '{$_POST['nazwa_aplikacji']}',\n";
        $appConfig .= "'wersja' => '{$_POST['wersja']}',\n";
        $appConfig .= "'brand' => '{$_POST['brand']}',\n";
        $appConfig .= "'phone' => '{$_POST['phone']}'\n";
        $appConfig .= "];\n";

        file_put_contents(__DIR__ . '/../includes/app-config.php', $appConfig);

        // Tworzenie konta administratora
        $conn = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['dbname']);
        $prefix = $config['prefix'];
        $email = $_POST['admin_login'];
        $hashed = password_hash($_POST['passwd'], PASSWORD_DEFAULT);

        $q = "INSERT INTO `{$prefix}uzytkownik` 
              (`imie`, `nazwisko`, `email`, `haslo`, `rola_id`) 
              VALUES ('Admin', 'Główny', '$email', '$hashed', 2)";
        //mysqli_query($conn, $q);

        if (!mysqli_query($conn, $q)) {
        die("Błąd zapytania: " . mysqli_error($conn));
        }

        echo "<h2>✅ Instalacja zakończona!</h2>";
        echo "<p><a href='../index.php'>Przejdź do aplikacji</a></p>";
        break;
}