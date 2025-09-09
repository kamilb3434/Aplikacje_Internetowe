<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Rejestracja w serwisie konferencyjnym" />
    <meta name="author" content="Twoja Firma" />
    <title>Rejestracja – Serwis konferencyjny</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Navigation -->
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
                    <li class="nav-item"><a class="nav-link" href="login.php">Zaloguj się</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Zarejestruj się</a></li>
                </ul>
            </div>
        </div>
    </nav>
<!-- Registration Section -->
<section class="bg-light pt-5 pb-5 mt-5 mb-5">
    <div class="container px-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Rejestracja</h3>
                        <form action="/register-handler.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                       placeholder="Imię" required>
                                <label for="firstName">Imię *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                       placeholder="Nazwisko" required>
                                <label for="lastName">Nazwisko *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Adres e-mail" required>
                                <label for="email">Adres e-mail *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="street" name="street"
                                       placeholder="Ulica" required>
                                <label for="street">Ulica *</label>
                            </div>
                            <div class="row gx-2 mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="streetNumber" name="streetNumber"
                                               placeholder="Numer ulicy" required>
                                        <label for="streetNumber">Numer ulicy *</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="apartmentNumber" name="apartmentNumber"
                                               placeholder="Numer lokalu">
                                        <label for="apartmentNumber">Numer lokalu </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="postalCode" name="postalCode"
                                       placeholder="00-000" pattern="\d{2}-\d{3}" required>
                                <label for="postalCode">Kod pocztowy *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="city" name="city"
                                       placeholder="Miejscowość" required>
                                <label for="city">Miejscowość *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="birthDate" name="birthDate"
                                       placeholder="Data urodzenia" required>
                                <label for="birthDate">Data urodzenia *</label>
                            </div>
                           <div class="form-floating mb-4">
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Hasło"
                                required
                                autocomplete="new-password"
                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])\S{8,72}"
                                title="Min. 8 znaków, bez spacji, z dużą i małą literą, cyfrą i znakiem specjalnym.">
                                <label for="password">Hasło *</label>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Zarejestruj się</button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        Masz już konto? <a href="login.php">Zaloguj się</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container px-4">
            <p class="m-0 text-center text-white">&copy; Serwis konferencyjny 2025
            </p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
