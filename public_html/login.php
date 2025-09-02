<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Strona logowania serwisu konferencyjnego" />
    <meta name="author" content="Twoja Firma" />
    <title>Logowanie – Serwis konferencyjny</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Navigation (kopiuj dalej z głównego szablonu)-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">
            <a class="navbar-brand" href="index.php">Serwis konferencyjny</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php#about">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#services">Usługi</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#contact">Kontakt</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Zaloguj się</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Zarejestruj się</a></li>
                </ul>
            </div>
        </div>
    </nav>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert">
        Nieprawidłowy login lub hasło.
    </div>
<?php endif; ?>
    <!-- Login Section -->
    <section class="vh-100 bg-light d-flex align-items-center">
        <div class="container px-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center">
                                Nieprawidłowy login lub hasło.
                        </div>
                    <?php endif; ?>
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <h3 class="card-title text-center mb-4">Logowanie</h3>
                            <form action="/login-handler.php" method="post">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="name@example.com" required>
                                    <label for="email">Adres e-mail</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Hasło" required>
                                    <label for="password">Hasło</label>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">
                                            Zapamiętaj mnie
                                        </label>
                                    </div>
                                    
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Zaloguj się</button>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            Nie masz konta? <a href="register.php">Zarejestruj się</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (kopiuj dalej z głównego szablonu)-->
    <footer class="py-5 bg-dark">
        <div class="container px-4">
            <p class="m-0 text-center text-white">&copy; Serwis konferencyjny 2025</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
