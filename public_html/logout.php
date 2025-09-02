<?php
session_start();           // Start sesji, jeśli działa
session_unset();           // Usunięcie wszystkich danych sesyjnych
session_destroy();         // Zamknięcie sesji
header("Location: login.php");  // Przekierowanie do strony logowania
exit;
