<?php

if (file_exists(__DIR__ . '/includes/config.php')) {
    die('Aplikacja została już zainstalowana.');
}

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;


switch ($step) {
    case 1:
        include 'steps/step1.php';
        break;
    case 2:
    case 3:
    case 4:
    case 6:
        include 'install-handler.php';
        break;
    case 5:
        include 'steps/step5.php';
        break;
    default:
        echo "Nieznany krok.";
        break;
}




