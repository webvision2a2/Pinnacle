<?php
require_once '../../controller/StageController.php';
require_once '../../controller/SocieteController.php';

// Instanciation des contrôleurs
$stageController = new StageController();
$societeController = new SocieteController();
$limit = 6; // Nombre de stages par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Assurer que la page est au moins 1
$offset = ($page - 1) * $limit;

// Récupération du filtre par société (si présent)
$societe_id = isset($_GET['societe']) ? (int)$_GET['societe'] : null;

if ($societe_id) {
    // Récupération des stages par société
    $stages = $stageController->listStagesBySociete($societe_id, $limit, $offset);
    $totalStages = $stageController->countStagesBySociete($societe_id);
} else {
    // Récupération des stages sans filtrage par société
    $stages = $stageController->listStagesWithPagination($limit, $offset);
    $totalStages = $stageController->countStages();
}

$totalPages = ceil($totalStages / $limit);

// Récupération des sociétés pour le filtre
$societes = $societeController->listSociete();
$latestStage = $stageController->getLatestStage();
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

    <style>
        /* Styles de notification carrée */
        .notification-square {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px;
            padding: 15px;
            background-color: #28a745; /* Couleur verte pour succès */
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            display: none; /* Cachée par défaut */
            align-items: center;
            justify-content: center;
            z-index: 1050;
            opacity: 0;
            transform: translateX(100%); /* Position initiale hors de l'écran */
            transition: opacity 0.4s ease, transform 0.4s ease; /* Transition douce */
        }

        .notification-square.show {
            opacity: 1;
            transform: translateX(0); /* Affichage avec animation */
        }

        /* Ajouter un effet au texte */
        .notification-square span {
            flex-grow: 1;
            font-weight: 500;
        }

        /* Styles de l'icône de fermeture */
        .notification-square .btn-close {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
        }

        /* Couleurs spécifiques pour différents types de notifications */
        .notification-square.success {
            background-color: #28a745; /* Vert pour succès */
        }

        .notification-square.error {
            background-color: #dc3545; /* Rouge pour erreur */
        }

        .notification-square.info {
            background-color: #17a2b8; /* Bleu pour information */
        }

        .notification-square.warning {
            background-color: #ffc107; /* Jaune pour avertissement */
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">

        <!-- Notification Area -->
        <div id="notification-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <!-- Notifications seront affichées ici -->
        </div>

        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
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
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Get Started</a>
                </div>
            </nav>

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
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
         
        <!-- Notification carrée -->
        
        <div id="notificationSquare" class="notification-square" style="display: none;">
            <span id="notificationText"></span>
            <!-- Lien vers les détails du stage -->
            <a href="#" id="notificationLink" class="btn-details text-white" style="font-size: 18px; margin-left: 10px;">Détails</a>
        </div>

        <script>
            // Fonction pour afficher la notification
            function showNotification(message, type = 'success', stageId = null) {
                var notification = document.getElementById('notificationSquare');
                var notificationText = document.getElementById('notificationText');
                var notificationLink = document.getElementById('notificationLink');

                // Définir le type de notification (success, error, info, warning)
                notification.classList.remove('success', 'error', 'info', 'warning');
                notification.classList.add(type);

                // Ajouter le message de la notification
                notificationText.textContent = message;
                
                // Ajouter le lien vers la page des détails du stage si un stageId est disponible
                if (stageId) {
                    notificationLink.setAttribute('href', 'stageDetails.php?id=' + stageId);  // Lien dynamique vers la page de détails du stage
                    notificationLink.style.display = 'inline-block'; // Assurez-vous que le lien est visible
                } else {
                    notificationLink.style.display = 'none';  // Masquer le lien si aucun ID n'est passé
                }

                // Afficher la notification avec une animation
                notification.style.display = 'flex';
                notification.classList.add('show');

                // Masquer la notification après 5 secondes
                setTimeout(function () {
                    notification.classList.remove('show');  // Retirer l'animation
                    setTimeout(function () {
                        notification.style.display = 'none';  // Cacher après l'animation
                    }, 400);  // Attendre la fin de la transition avant de cacher
                }, 5000);  // Cacher après 5 secondes
            }

            // Vérification de l'existence de `latestStage` et affichage de la notification
            <?php if ($latestStage): ?>
                // Afficher une notification pour le dernier stage ajouté avec un lien vers la page des détails
                showNotification('New stage: <?= htmlspecialchars($latestStage['nom_stage']); ?> has been added.', 'success', <?= $latestStage['id_stage']; ?>);
            <?php else: ?>
                // Si aucun stage, afficher une notification d'erreur sans lien
                showNotification('No stage found.', 'error');
            <?php endif; ?>


        </script>

        <!-- Stages Section Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <h1 class="text-center mb-5">List of Our Stages</h1>

                <!-- Recherche par société -->
                <form action="main2.php" method="get" class="mb-4">
                    <label for="societe" class="form-label">Filter by Societe</label>
                    <select name="societe" id="societe" class="form-select" onchange="this.form.submit()">
                        <option value="">All Societies</option>
                        <?php foreach ($societes as $societe): ?>
                            <option value="<?= $societe['id'] ?>" <?= $societe['id'] == $societe_id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($societe['nom_soc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <div class="row g-4">
                    <?php foreach ($stages as $stage): ?>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item d-flex flex-column text-center rounded">
                                <div class="service-icon flex-shrink-0">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                </div>
                                
                                <?php 
                                    $societeName = 'Unknown'; // Valeur par défaut
                                    foreach ($societes as $societe) {
                                        if ($societe['id'] == $stage['id_societe']) {
                                            $societeName = htmlspecialchars($societe['nom_soc']);
                                            break;
                                        }
                                    }
                                ?>

                                <h5 class="mb-3"><?= htmlspecialchars($stage['nom_stage']); ?> - <?= $societeName; ?></h5>
                                <p class="m-0"><?= htmlspecialchars($stage['speciality']); ?></p>
                                <p class="m-0"><?= htmlspecialchars($stage['duration']); ?></p>
                                <p class="m-0"><?= htmlspecialchars($stage['email']); ?></p>
                                <a class="btn btn-square" href="stageDetails.php?id=<?= $stage['id_stage']; ?>"><i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination mt-5 text-center">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&societe=<?= $societe_id ?>" class="btn btn-primary">Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&societe=<?= $societe_id ?>" class="btn btn-outline-primary <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&societe=<?= $societe_id ?>" class="btn btn-primary">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Stages Section End -->

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