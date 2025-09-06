<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Prefix z jedynego configa
$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];

// Dostęp tylko dla admina
if (!isset($_SESSION['user_id']) || (int)$_SESSION['rola_id'] !== 2) {
    header("Location: ../login.php");
    exit;
}

// POBIERAMY REFERATY (a nie ogłoszenia)
$sql = "
    SELECT r.id, r.tytul, r.data_zgloszenia, r.status, r.plik,
           u.imie, u.nazwisko
    FROM `{$prefix}referaty` r
    JOIN `{$prefix}uzytkownik` u ON u.id = r.uczestnik_id
    ORDER BY r.data_zgloszenia DESC
";
$stmt = $pdo->query($sql);
$referaty = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel administratora – Referaty</title>

    <!-- SB Admin 2 -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        html, body { height: 100%; }
        #content-wrapper { min-height: 100%; display: flex; flex-direction: column; }
        .sticky-footer { margin-top: auto; }
    </style>

    <!-- SweetAlert2 (motyw Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminDashboard.php">
            <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-cog"></i></div>
            <div class="sidebar-brand-text mx-3">Panel <sup>Administratora</sup></div>
        </a>

        <hr class="sidebar-divider my-0">
        <li class="nav-item"><a class="nav-link" href="adminDashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <hr class="sidebar-divider">
        <li class="nav-item"><a class="nav-link" href="uzytkownicy.php"><i class="fas fa-fw fa-users"></i><span>Użytkownicy</span></a></li>
        <hr class="sidebar-divider">
        <li class="nav-item"><a class="nav-link" href="ogloszenia.php"><i class="fas fa-fw fa-bullhorn"></i><span>Ogłoszenia</span></a></li>
        <hr class="sidebar-divider">
        <li class="nav-item active"><a class="nav-link" href="referaty.php"><i class="fas fa-fw fa-file-alt"></i><span>Referaty</span></a></li>
        <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- /Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- User dropdown z wylogowaniem (avatar + link) -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?= htmlspecialchars($_SESSION['imie'] . ' ' . $_SESSION['nazwisko'], ENT_QUOTES, 'UTF-8'); ?>
                          </span>
                          <img id="userAvatar" class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="Profil" style="cursor:pointer">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logoutLink" href="../logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Wyloguj się
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /Topbar -->

            <div class="container-fluid mt-4">
                <h1 class="h3 mb-4 text-gray-800">Zgłoszone referaty</h1>

                <?php if (empty($referaty)): ?>
                    <p>Brak zgłoszeń referatów.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tytuł</th>
                                    <th>Autor</th>
                                    <th>Data zgłoszenia</th>
                                    <th>Status</th>
                                    <th>Plik</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($referaty as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r['tytul'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($r['imie'] . ' ' . $r['nazwisko'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($r['data_zgloszenia'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <?php
                                          $kolor = match($r['status']) {
                                              'zaakceptowany' => 'success',
                                              'odrzucony'     => 'danger',
                                              default         => 'secondary'
                                          };
                                        ?>
                                        <span class="badge badge-<?= $kolor ?>"><?= htmlspecialchars($r['status'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($r['plik'])): ?>
                                            <!-- Otwórz w nowej karcie / wymuś pobranie przez centralny downloader -->
                                            <a class="btn btn-link p-0 mr-2"
                                               href="../download_referat.php?id=<?= (int)$r['id'] ?>" target="_blank" rel="noopener">Otwórz</a>
                                            <a class="btn btn-link p-0"
                                               href="../download_referat.php?id=<?= (int)$r['id'] ?>&dl=1">Pobierz</a>
                                        <?php else: ?>
                                            Brak
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['status'] === 'oczekujący'): ?>
                                            <a href="referat_status.php?id=<?= (int)$r['id'] ?>&akcja=zaakceptuj" class="btn btn-success btn-sm">Akceptuj</a>
                                            <a href="referat_status.php?id=<?= (int)$r['id'] ?>&akcja=odrzuc" class="btn btn-danger btn-sm">Odrzuć</a>
                                        <?php else: ?>
                                            <span class="text-muted">Brak akcji</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>&copy; Serwis konferencyjny 2025</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/sb-admin-2.min.js"></script>

<script>
(function () {
  function niceLogoutDialog(onConfirm) {
    if (window.Swal) {
      Swal.fire({
        title: 'Wylogować się?',
        text: 'Zostaniesz wylogowany/a z panelu.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Wyloguj',
        cancelButtonText: 'Anuluj',
        reverseButtons: true,
        customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-secondary' },
        buttonsStyling: false
      }).then(function (res) { if (res.isConfirmed) onConfirm(); });
    } else {
      if (confirm('Czy na pewno chcesz się wylogować?')) onConfirm();
    }
  }

  var avatar = document.getElementById('userAvatar');
  if (avatar) {
    avatar.addEventListener('click', function (e) {
      e.preventDefault(); e.stopPropagation();
      niceLogoutDialog(function(){ window.location.href = '../logout.php'; });
    }, true);
  }

  var logout = document.getElementById('logoutLink');
  if (logout) {
    logout.addEventListener('click', function (e) {
      e.preventDefault();
      niceLogoutDialog(function(){ window.location.href = '../logout.php'; });
    });
  }
})();
</script>
</body>
</html>
