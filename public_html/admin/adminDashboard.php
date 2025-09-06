<?php
session_start();

// Zabezpieczenie – tylko administrator (rola_id = 2) może tu wejść
if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Ładowanie połączenia z bazą danych i konfiguracji
require_once '../includes/db.php';
$config = include '../includes/config.php';
$prefix = $config['prefix'];

// 📊 Kafelek z ilością użytkowników
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM {$prefix}uzytkownik");
$row = $stmt->fetch();
$iloscUzytkownikow = $row['total'];

// 📄 Kafelek z ilością referatów
$stmt = $pdo->query("SELECT COUNT(*) FROM {$prefix}referaty");
$liczbaReferatow = $stmt->fetchColumn();

// 📈 Dane do wykresu: ilość referatów zgłoszonych w każdym miesiącu bieżącego roku
$referaty_miesiac = [];
for ($m = 1; $m <= 12; $m++) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM {$prefix}referaty 
        WHERE MONTH(data_zgloszenia) = ? AND YEAR(data_zgloszenia) = YEAR(CURDATE())
    ");
    $stmt->execute([$m]);
    $referaty_miesiac[] = (int)$stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel administratora</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- (NOWE) SweetAlert2 theme dopasowany do Bootstrap 4 xq -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminDashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Panel <sup>Administratora</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="adminDashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="uzytkownicy.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Użytkownicy</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="ogloszenia.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Ogłoszenia</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="referaty.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Referaty</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information xq-->
                        <li class="nav-item dropdown no-arrow">
                          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                              <?= htmlspecialchars($_SESSION['imie'] . ' ' . $_SESSION['nazwisko'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>

                            <!-- Avatar xq-->
                            <img id="userAvatar"
                                 class="img-profile rounded-circle"
                                 src="img/undraw_profile.svg"
                                 alt="Profil"
                                 style="cursor:pointer">
                          </a>

                          <!-- Dropdown - User Information xq-->
                          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                               aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                              Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <!-- Pozycja Wyloguj z potwierdzeniem xq-->
                            <a class="dropdown-item" id="logoutLink" href="../logout.php">
                              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              Wyloguj się
                            </a>
                          </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Witaj w panelu Administratora!</h1>
                    </div>

                    <div class="row">
                        <!-- Kafelek - Dzisiejsza data -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dzisiaj</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo date('d.m.Y'); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kafelek godzina -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Zegar</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="liveClock">--:--:--</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kafelek - Referaty -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Referaty</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $liczbaReferatow ?></div>
                                                </div>
                                                <div class="col"></div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kafelek - Użytkownicy -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Użytkownicy</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $iloscUzytkownikow ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Serwis konferencyjny 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- (NOWE) SweetAlert2 skrypt xq-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Potwierdzenie wylogowania (avatar + link w dropdownie) xq-->
    <script>
      (function () {
        // Funkcja 
        function niceLogoutDialog(onConfirm) {
          if (window.Swal && typeof Swal.fire === 'function') {
            Swal.fire({
              title: 'Wylogować się?',
              text: 'Zostaniesz wylogowany/a z panelu.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Wyloguj',
              cancelButtonText: 'Anuluj',
              reverseButtons: true,
              focusCancel: true,
              customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
              },
              buttonsStyling: false
            }).then(function (result) {
              if (result.isConfirmed) onConfirm();
            });
          } else {
            if (confirm('Czy na pewno chcesz się wylogować?')) onConfirm();
          }
        }

        // Klik w avatar: zatrzymaj dropdown i pokaż dialog 
        var avatar = document.getElementById('userAvatar');
        if (avatar) {
          avatar.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            niceLogoutDialog(function () {
              window.location.href = '../logout.php';
            });
          }, true);
        }

        // Klik w „Wyloguj się” w menu 
        var logout = document.getElementById('logoutLink');
        if (logout) {
          logout.addEventListener('click', function (e) {
            e.preventDefault();
            niceLogoutDialog(function () {
              window.location.href = '../logout.php';
            });
          });
        }
      })();
    </script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Wyświetlanie aktualnej godziny  -->
    <script>
      function updateClock() {
          const now = new Date();
          const timeString = now.toLocaleTimeString('pl-PL', { hour12: false });
          document.getElementById('liveClock').textContent = timeString;
      }
      setInterval(updateClock, 1000);
      updateClock();
    </script>

</body>
</html>
