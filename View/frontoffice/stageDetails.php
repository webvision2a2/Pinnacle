<?php
require_once '../../controller/StageController.php';
require_once '../../controller/SocieteController.php';

// Vérifiez si l'ID du stage est passé en paramètre
if (isset($_GET['id'])) {
    $id_stage = $_GET['id'];
    $stageController = new StageController();
    $stage = $stageController->showStage($id_stage);

    if ($stage) {
        $societeController = new SocieteController();
        $societe = $societeController->showSociete($stage['id_societe']);
    } else {
<<<<<<< HEAD
        // Afficher un message d'erreur si le stage n'est pas trouvé
        echo "<p>Stage non trouvé.</p>";
        exit();
    }
} else {
    // Afficher un message d'erreur si l'ID est manquant
    echo "<p>ID de stage manquant.</p>";
=======
        echo "Stage non trouvé.";
        exit();
    }
} else {
    echo "ID de stage manquant.";
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
    exit();
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>DGital - Détails du Stage</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Détails du stage et de l'entreprise" name="keywords">
    <meta content="Consultez les informations détaillées sur le stage et l'entreprise." name="description">
=======
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DGital - Digital Agency HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">

<<<<<<< HEAD
        <!-- Navbar Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.php" class="navbar-brand p-0">
=======
        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
                    <h1 class="m-0">DGital</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link">Home</a>
<<<<<<< HEAD
                        <a href="main.php" class="nav-item nav-link">Sociétés</a>
                        <a href="main2.php" class="nav-item nav-link ">Stages</a>
=======
                        <a href="main.php" class="nav-item nav-link">Societes</a>
                        <a href="main2.php" class="nav-item nav-link active">Stages</a>
                        <a href="project.html" class="nav-item nav-link">Project</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Get Started</a>
                </div>
            </nav>
<<<<<<< HEAD
        </div>
        <!-- Navbar End -->

        <!-- Hero Section Start -->
        <div class="container-xxl py-5 bg-primary hero-header">
            <div class="container my-5 py-5 px-lg-5">
                <div class="row g-5 py-5">
                    <div class="col-12 text-center">
                        <h1 class="text-white animated slideInDown">Détails du Stage</h1>
                        <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                                <li class="breadcrumb-item text-white " aria-current="page">Détails du Stage</li>
                            </ol>
                        </nav>
=======

            <div class="container-xxl py-5 bg-primary hero-header">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-12 text-center">
                            <h1 class="text-white animated slideInDown">Our Stages</h1>
                            <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                                    <li class="breadcrumb-item text-white active" aria-current="page">Stages</li>
                                </ol>
                            </nav>
                        </div>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD
        <!-- Hero Section End -->

        <!-- Stage Details Start -->
        <div class="container py-5 px-lg-5">
            <div class="row g-4">
                <!-- Stage Info -->
                <div class="col-lg-6 col-md-6">
                    <h3 class="mb-4">Informations sur le Stage</h3>
                    <p><strong>Nom du Stage :</strong> <?= htmlspecialchars($stage['nom_stage']); ?></p>
                    <p><strong>Type :</strong> <?= htmlspecialchars($stage['type']); ?></p>
                    <p><strong>Durée :</strong> <?= htmlspecialchars($stage['duration']); ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($stage['email']); ?></p>
                    <p><strong>Spécialité :</strong> <?= htmlspecialchars($stage['speciality']); ?></p>
                    <p><strong>Documents :</strong> <?= htmlspecialchars($stage['documents']); ?></p>
                </div>

                <!-- Company Info -->
                <div class="col-lg-6 col-md-6">
                    <h3 class="mb-4">Informations sur la Société</h3>
                    <p><strong>Nom de la Société :</strong> <?= htmlspecialchars($societe['nom_soc']); ?></p>
                    <p><strong>Adresse :</strong> <?= htmlspecialchars($societe['adresse']); ?></p>
                    <p><strong>Numéro :</strong> <?= htmlspecialchars($societe['numero']); ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($societe['email']); ?></p>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="main3.php?id=<?= $id_stage ?>" class="btn btn-success">Postuler pour ce Stage</a>
            </div>
            <div class="text-center mt-4">
                <a href="main2.php" class="btn btn-primary">Retour à la liste des stages</a>
            </div>
            
        </div>
        <!-- Stage Details End -->
=======
        <!-- Navbar & Hero End -->

        <!-- Service Start -->
        <h1 class="text-center">Détails du Stage</h1>
    <div class="stage-details">
        <h2>Informations sur le Stage</h2>
        <p><strong>Type :</strong> <?= htmlspecialchars($stage['type']); ?></p>
        <p><strong>Durée :</strong> <?= htmlspecialchars($stage['duration']); ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($stage['email']); ?></p>
        <p><strong>Spécialité :</strong> <?= htmlspecialchars($stage['speciality']); ?></p>
        <p><strong>Documents :</strong> <?= htmlspecialchars($stage['documents']); ?></p>
    </div>
    <div class="societe-details">
        <h2>Informations sur la Société</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($societe['nom_soc']); ?></p>
        <p><strong>Adresse :</strong> <?= htmlspecialchars($societe['adresse']); ?></p>
        <p><strong>Numéro :</strong> <?= htmlspecialchars($societe['numero']); ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($societe['email']); ?></p>
    </div>
    <a href="main2.php" class="btn btn-primary">Retour à la liste des stages</a>
        <!-- Service End -->
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
<<<<<<< HEAD
                        <p class="section-title text-white h5 mb-4">Contact</p>
=======
                        <p class="section-title text-white h5 mb-4">Address<span></span></p>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
                        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
<<<<<<< HEAD
            
        
=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<<<<<<< HEAD
=======

>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<<<<<<< HEAD
=======


>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
