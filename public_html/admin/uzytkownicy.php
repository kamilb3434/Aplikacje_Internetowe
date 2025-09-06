<?php
session_start();

// Wymuś zalogowanie jako administrator
if (!isset($_SESSION['user_id']) || $_SESSION['rola_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Wczytaj konfigurację instalatora
$config = include __DIR__ . '/../includes/config.php';
$prefix = $config['prefix'];

// Ustaw połączenie PDO zgodnie z danymi z konfiguracji
$host = $config['host'];
$db   = $config['dbname'];
$user = $config['user'];
$pass = $config['pass'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

// Pobierz użytkowników z prefiksowanej tabeli
try {
    $stmt = $pdo->query("SELECT id, imie, nazwisko, email, adres_kod_pocztowy, adres_miejscowosc, status FROM {$prefix}uzytkownik");
    $uzytkownicy = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Błąd zapytania: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panel administratora</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    
    <style>
        html, body {
            height: 100%;
        }

        #content-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sticky-footer {
            margin-top: auto;
        }
    </style>

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

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="adminDashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Użytkownicy -->
            <li class="nav-item">
                <a class="nav-link" href="uzytkownicy.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Użytkownicy</span></a>
            </li>

                   <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Ogłoszenia -->
            <li class="nav-item">
                <a class="nav-link" href="ogloszenia.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Ogłoszenia</span></a>
            </li>

             <!-- Divider -->
            <hr class="sidebar-divider">

               <li class="nav-item">
                <a class="nav-link" href="referaty.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Referaty</span></a>
            </li>


            <!-- Divider -->
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


  



<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Lista użytkowników</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Zarejestrowani użytkownicy</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Kod pocztowy</th>
                            <th>Miejscowość</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($uzytkownicy as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['imie']) ?></td>
                            <td><?= htmlspecialchars($user['nazwisko']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['adres_kod_pocztowy']) ?></td>
                            <td><?= htmlspecialchars($user['adres_miejscowosc']) ?></td>
                            <td>
                                <?= $user['status'] == 1 
                                    ? '<span class="badge badge-success">Aktywny</span>' 
                                    : '<span class="badge badge-secondary">Nieaktywny</span>' ?>
                            </td>
                            <td>
                                <a href="podglad_uzytkownika.php?id=<?= $user['id'] ?>" class="btn btn-info btn-sm">Podgląd</a>
                                <a href="edytuj_uzytkownika.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edytuj</a>
                                <?php if ($user['status'] == 1): ?>
                                    <a href="zmien_status.php?id=<?= $user['id'] ?>&akcja=dezaktywuj" class="btn btn-danger btn-sm">Dezaktywuj</a>
                                <?php else: ?>
                                    <a href="zmien_status.php?id=<?= $user['id'] ?>&akcja=aktywuj" class="btn btn-success btn-sm">Aktywuj</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


             

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> &copy; Serwis konferencyjny 2025</span>
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

    <!-- Komunikat o wylogowanie-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz się wylogować?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Kliknij „Wyloguj się”, aby zakończyć bieżącą sesję.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>
                    <a class="btn btn-primary" href="../logout.php">Wyloguj się</a>
            </div>
        </div>
    </div>

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
</body>

</html>

