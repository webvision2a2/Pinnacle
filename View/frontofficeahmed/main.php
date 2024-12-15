<?php
require_once '../../controller/SocieteController.php';

$societeController = new SocieteController();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 6; // Nombre de sociétés par page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$list = $societeController->searchAndPaginate($search, $limit, $offset);
$totalSocietes = $societeController->countSearchResults($search);
$totalPages = ceil($totalSocietes / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DGital - Digital Agency HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">

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
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img class ='logo' src="img/LOGO 1 blue.png">
                    <h1 class="m-0">Pinnacle</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto py-0">
                        <li class="nav-item">
                            <a href="../frontOffice_zeineb/Template/index.php" class="nav-link text-white">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontoff/catalogue.php" class="nav-link text-white">Catalogue</a>
                        </li>
                        <li class="nav-item">
                            <a href="quiz.php" class="nav-link text-white">Entretien</a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php" class="nav-item nav-link active">Societes</a>
                        </li>
                        <li class="nav-item">
                            <a href="main2.php" class="nav-item nav-link">Stages</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontoffice moemen/topicsPage.php" class="nav-link text-white">Psychologie</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                                Événement <span class="arrow">&#9660;</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../FrontOffice/eventdispo.php" class="dropdown-item">Nos événements</a>
                                </li>
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#addEventModal">Ajouter un événement</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../frontOffice_zeineb/Template/profile.php" class="nav-link text-white">Profil</a>
                        </li>
                    </ul>

                    <!-- User Greeting and Logout Button -->

                    <a href="../frontOffice_zeineb/logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-12 text-center">
                            <h1 class="text-white animated slideInDown">Our Companies</h1>
                            <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                                    <li class="breadcrumb-item text-white active" aria-current="page">Companies</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Search and Filter Start -->
        <div class="container py-5">
            <form method="GET" action="main.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search by name"
                        value="<?= htmlspecialchars($search); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <!-- Search and Filter End -->

        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <h1 class="text-center mb-5">List of Our Companies</h1>
                <div class="row g-4">
                    <?php foreach ($list as $societe): ?>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item d-flex flex-column text-center rounded">
                                <div class="service-icon flex-shrink-0">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                                <h5 class="mb-3"><?= htmlspecialchars($societe['nom_soc']); ?></h5>
                                <p class="m-0"><strong>Speciality:</strong> <?= htmlspecialchars($societe['speciality']); ?>
                                </p>
                                <p class="m-0"><strong>Address:</strong> <?= htmlspecialchars($societe['adresse']); ?></p>
                                <p class="m-0"><strong>Phone:</strong> <?= htmlspecialchars($societe['numero']); ?></p>
                                <p class="m-0"><strong>Email:</strong> <?= htmlspecialchars($societe['email']); ?></p>
                                <div class="mt-3">
                                    <a class="btn btn-outline-primary"
                                        href="companyDetails.php?id=<?= $societe['id']; ?>">See Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Start -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link"
                                    href="?page=<?= $i; ?>&search=<?= htmlspecialchars($search); ?>"><?= $i; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- Pagination End -->
            </div>
        </div>
        <!-- Service End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Address<span></span></p>
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

        <!-- Back to Top -->
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>