<?php
require_once '../../controller/SocieteController.php';

// Vérification de l'ID de la société dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $societeController = new SocieteController();
    $societe = $societeController->getSocieteById($_GET['id']);
    
    // Si la société n'est pas trouvée, afficher un message
    if (!$societe) {
        echo "<p>Société non trouvée.</p>";
        exit();
    }
} else {
    echo "<p>ID de la société manquant ou invalide.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGital - Détails de la société</title>
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome & Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap & Custom Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">

        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="m-0">DGital</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="main.php" class="nav-item nav-link active">Sociétés</a>
                    <a href="main2.php" class="nav-item nav-link">Stages</a>
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div>
                <a href="" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Get Started</a>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Hero Section -->
        <div class="container-xxl py-5 bg-primary hero-header">
            <div class="container my-5 py-5 px-lg-5">
                <div class="row g-5 py-5">
                    <div class="col-12 text-center">
                        <h1 class="text-white animated slideInDown">Détails de la Société</h1>
                        <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a class="text-white" href="#">Accueil</a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page">Sociétés</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Section End -->

        <!-- Company Details Start -->
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-12">
                    <h1 class="display-5 mb-4"><?= htmlspecialchars($societe['nom_soc']); ?></h1>
                    <ul class="list-unstyled">
                        <li><strong>Spécialité:</strong> <?= htmlspecialchars($societe['speciality']); ?></li>
                        <li><strong>Adresse:</strong> <?= htmlspecialchars($societe['adresse']); ?></li>
                        <li><strong>Téléphone:</strong> <?= htmlspecialchars($societe['numero']); ?></li>
                        <li><strong>Email:</strong> <?= htmlspecialchars($societe['email']); ?></li>
                    </ul>
                    <a class="btn btn-primary" href="main.php">Retour aux sociétés</a>
                </div>
            </div>
        </div>
        <!-- Company Details End -->

        <!-- Footer Start -->
        <footer>
            <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5 px-lg-5">
                    <div class="row g-5">
                        <div class="col-md-6 col-lg-3">
                            <p class="section-title text-white h5 mb-4">Adresse</p>
                            <p><i class="fa fa-map-marker-alt me-3"></i>123 Rue, New York, USA</p>
                            <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                            <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                            <div class="d-flex pt-2">
                                <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Back to Top Button -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
