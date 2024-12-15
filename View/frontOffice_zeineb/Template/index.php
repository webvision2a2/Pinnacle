<?php
session_start();

if ($_SESSION["loggedin"] !== true) {
    $_SESSION = array();
    header("location: ../login.php");
    session_destroy();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Acceuil</title>
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
                <!-- Brand Logo and Name -->
                <a href="#" class="navbar-brand d-flex align-items-center p-0">
                    <img class="logo me-2" src="img/LOGO 1 blue.png" alt="Pinnacle Logo" style="max-width: 45px;">
                    <h1 class="m-0" style="margin-right: 20px;">Pinnacle</h1>
                </a>

                <!-- Navbar Toggler for Mobile View -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-white"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto py-0">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link text-white active">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../frontoff/catalogue.php" class="nav-link text-white">Catalogue</a>
                        </li>
                        <li class="nav-item">
                        <a href="../../frontOfficeChams/quiz.php" class="nav-link text-white">Entretien</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../frontofficeahmed/main.php" class="nav-link text-white">Sociétés</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../frontofficeahmed/main2.php" class="nav-link text-white">Stages</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../frontoffice moemen/topicsPage.php" class="nav-link text-white">Psychologie</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                                Événement <span class="arrow">&#9660;</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../../FrontOffice/eventdispo.php" class="dropdown-item">Nos événements</a>
                                </li>
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#addEventModal">Ajouter un événement</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="profile.php" class="nav-link text-white">Profil</a>
                        </li>
                    </ul>

                    <!-- User Greeting and Logout Button -->

                    <div class="text-end me-3">
                        <h6 class="mb-0 text-white">Bienvenue,</h6>
                        <span class="fw-bold text-warning">
                            <?php echo htmlspecialchars($_SESSION['nom']) . ' ' . htmlspecialchars($_SESSION['prenom']); ?>
                        </span>

                        <!-- <small class="text-light">Content de vous voir ici !</small> -->
                    </div>

                    <a href="../logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
                </div>
            </nav>

            <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEventModalLabel">Ajouter un événement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Load the external page inside an iframe -->
                            <iframe src="../FrontOffice/Evenement.php"
                                style="width: 100%; height: 500px; border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .arrow {
                    margin-left: 8px;
                    /* Space between text and arrow */
                    display: inline-block;
                    transition: transform 0.3s ease, color 0.3s ease;
                    /* Smooth flip and color transition */
                    font-size: 16px;
                    /* Adjust the size of the arrow */
                    color: #fff;
                    /* Default arrow color */
                }

                /* When the dropdown is open (hover or active state) */
                .nav-link.dropdown-toggle:hover .arrow,
                .nav-item.show .nav-link.dropdown-toggle .arrow {
                    transform: rotate(180deg);
                    /* Flip the arrow to indicate it's expanded */
                    color: #FBA504;
                    /* Change the color on hover */
                }

                .modal {
                    z-index: 1050;
                    /* Ensure modal appears above other elements */
                    display: none;
                    /* Hidden by default */
                    position: fixed;
                    left: 10;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgba(0, 0, 0, 0.3);
                    /* Darker backdrop */
                    padding-top: 0px;
                }

                .modal-content {
                    background-color: #fff;
                    border-radius: 15px;
                    margin: 5% auto;
                    /* Center the modal */
                    width: 250%;
                    /* Adjust width */
                    /* max-width: 700px; Set a maximum width */
                    padding: 30px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
                    /* Add a shadow */
                    text-align: center;
                }

                .modal-header {
                    font-size: 1.5rem;
                    font-weight: bold;
                    color: #007BFF;
                    margin-bottom: 15px;
                }

                .modal-body {
                    font-size: 1.2rem;
                    color: #555;
                    margin-bottom: 20px;
                }

                .close {
                    color: #aaa;
                    float: right;
                    font-size: 1.5rem;
                    font-weight: bold;
                    cursor: pointer;
                    position: absolute;
                    right: 20px;
                    top: 10px;
                }

                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                }
            </style>
        </div>


        <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5 align-items-end">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">Transformez votre diplôme en opportunités</h1>
                            <p class="text-white pb-3 animated slideInDown">un site web professionnel a pour mission d'aider les étudiants récemment diplômés à naviguer dans le monde professionnel de l'informatique</p>
                           
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid animated zoomIn" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary justify-content-center"><span></span>Nos offres et services<span></span></p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-laptop-code fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Catalogue des Domaines IT</h5>
                            <p class="m-0">Une plateforme interactive où les étudiants peuvent explorer divers domaines de l'informatique, tels que le développement logiciel, la cybersécurité, le cloud computing, et plus encore.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-calendar fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Evenements</h5>
                            <p class="m-0"> Des événements variés dans divers domaines permettent aux étudiants d'acquérir plusieurs connaissances et compétences.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-book fa-2x"></i>
                            </div>
                            <h5 class="mb-3">chatbot </h5>
                            <p class="m-0">Des tests et questionnaires pour aider les  étudiants à se préparer aux entretiens d'embauche</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-mail-bulk fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Réseau et  Opportunités</h5>
                            <p class="m-0">Opportunités de travailler sur des projets concrets en collaboration avec des entreprises partenaires.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fas fa-brain   fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Support psychologique</h5>
                            <p class="m-0">Ressources pour aider les étudiants à gérer le stress et améliorer leurs compétences interpersonnelles.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fas fa-puzzle-piece  fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Jeux educatifs</h5>
                            <p class="m-0"> des outils ludiques conçus pour enseigner des concepts, des compétences ou des connaissances tout en divertissant les joueurs.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->

        <div class="container-xxl py-5">
    <div class="container py-5 px-lg-5">
        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <p class="section-title text-secondary justify-content-center">
                <span></span>Les meilleures entreprises recrutent nos alumni<span></span>
            </p>
        </div>
        
        <!-- Conteneur pour les images -->
        <div class="d-flex justify-content-center align-items-center flex-wrap">
            <div class="elementor-element elementor-element-170bcc2a elementor-widget elementor-widget-image" data-id="170bcc2a" data-element_type="widget" data-widget_type="image.default">
               
            <div class="elementor-element elementor-element-6c182edd elementor-widget elementor-widget-image" data-id="6c182edd" data-element_type="widget" data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="1087" height="147" src="https://gomycode.com/tn/wp-content/uploads/sites/26/2024/07/Group-1000005104.svg" class="attachment-full size-full wp-image-29714" alt="">
                </div>
            </div>
        </div>

      
    </div>
</div>
        <!-- Facts End -->
        <!-- Team Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary justify-content-center"><span></span>Our Team<span></span></p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/eya.jpg" alt="">
                                <h5>Eya Mariem Ezzaier</h5>
                                <span>responsable departement gestion de catalogue</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/zeineb.jpg" alt="">
                                <h5>Zeineb Doghri</h5>
                                <span>responsable departement gestion des utilisateurs</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/chams.jpg" alt="">
                                <h5>Chams Nmiri</h5>
                                <span>responsable departement gestion du chatbot</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/ahmed.jpg" alt="">
                                <h5>Ahmed Hbaieb</h5>
                                <span>responsable departement gestion de reseau</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/dhia.jpg" alt="">
                                <h5>Dhia Allegui</h5>
                                <span>responsable departement gestion des evenements</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/moemen.jpg" alt="">
                                <h5>Moemen Banannou</h5>
                                <span>responsable departement gestion des aateliers psychologiues</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
        

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Address<span></span></p>
                        <p><i class="fa fa-map-marker-alt me-3"></i>Esprit,Ariana soghra</p>
                        <p><i class="fa fa-phone-alt me-3"></i>0000000</p>
                        <p><i class="fa fa-envelope me-3"></i>pinnacle@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                   
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">pinnacle</a>, All Right Reserved. 
                            
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