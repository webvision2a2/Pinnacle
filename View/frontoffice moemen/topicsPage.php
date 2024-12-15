<?php
    require_once '../../Controller/topicController.php';
    require_once '../../Controller/commentController.php'; // Ajouter le contrôle des commentaires
    require_once '../../Model/topic.php';
    

    $topicController = new TopicController();
    $topics = $topicController->getTopic();

    $commentController = new CommentController(); // Instancier le contrôleur de commentaires

    // Récupérer le nombre de commentaires pour chaque sujet
    foreach ($topics as &$topic) {
        $topic['num_comments'] = $commentController->getCommentsCount($topic['id']);
    }
    // Réinitialisation de la référence
    unset($topic);
    

    // Trier les sujets en fonction du nombre de commentaires
    usort($topics, function($a, $b) {
        return $b['num_comments'] - $a['num_comments']; // Trie décroissant, plus de commentaires en premier
    });
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Topics Page</title>
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
        <link href="./frontoffice/lib/animate/animate.min.css" rel="stylesheet">
        <link href="./frontoffice/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="./frontoffice/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="./frontoffice/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="./frontoffice/css/style.css" rel="stylesheet">


        <link rel="stylesheet" href="styletopicsPage.css">

        
    </head>

    <body>
        
         
            <!-- Spinner End -->

            <!-- Navbar & Hero Start -->
                <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <!-- Brand Logo and Name -->
                <a href="#" class="navbar-brand d-flex align-items-center p-0">
                <img class ='logo' src="./frontoffice/img/LOGO 1 blue.png">
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
                            <a href="../frontOffice_zeineb/Template/index.php" class="nav-link text-white">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontoff/catalogue.php" class="nav-link text-white">Catalogue</a>
                        </li>
                        <li class="nav-item">
                        <a href="../frontOfficeChams/quiz.php" class="nav-link text-white">Entretien</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontofficeahmed/main.php" class="nav-link text-white">Sociétés</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontofficeahmed/main2.php" class="nav-link text-white">Stages</a>
                        </li>
                        <li class="nav-item">
                            <a href="topicsPage.php" class="nav-link text-white active">Psychologie</a>
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


                    <a href="../logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
                </div>
            </nav>

                <div class="container-xxl py-5 bg-primary hero-header">
                    <div class="container my-5 py-5 px-lg-5">
                    
                    </div>
                </div>
            </div>
            <!-- Navbar & Hero End -->

            <div class="container-xxl py-5">
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <!-- Optional: Add a header or introductory text here -->
                    </div>
                    
                    <div class="container-xxl p-0">
                        <div class="container mt-4">
                            <div class="row justify-content-center">
                                <div class="wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="row g-3">
                                        <?php if (!empty($topics)): ?>

                                            <?php foreach($topics as $topic) : ?>
                                                <div class="col-12 col-sm-4">
                                                    <div class="card h-100 shadow-sm"> <!-- Added shadow for depth -->
                                                        <div class="card-body d-flex flex-column">
                                                        
                                                            <h4 class="card-title"><?php echo $topic['title']; ?></h4>
                                                            <div class="card-image">
                                                                <!-- Lazy Loading Image -->
                                                                <img src="<?php echo $topic['image']; ?>" alt="<?php echo $topic['title']; ?>" >
                                                            </div>
                                                            <br>
                                                            <p class="card-text flex-grow-1"><?php echo $topic['description']; ?></p>
                                                            <!-- Afficher le nombre de commentaires -->
                                                            <p><strong>Nombre de commentaires :</strong> <?php echo $topic['num_comments']; ?></p>

                                                            <a href="readTopic.php?id=<?php echo $topic['id']; ?>" class="btn btn-primary">See more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        
                                        <?php else: ?>
                                            <div class="col-12 text-center">
                                                <p>No topics available at the moment.</p> <!-- Message for no topics -->
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Footer Start -->
            <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5 px-lg-5">            
                </div>
            </div>
            <!-- Footer End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>        
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./frontoffice/lib/wow/wow.min.js"></script>
        <script src="./frontoffice/lib/easing/easing.min.js"></script>
        <script src="./frontoffice/lib/waypoints/waypoints.min.js"></script>
        <script src="./frontoffice/lib/counterup/counterup.min.js"></script>
        <script src="./frontoffice/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="./frontoffice/lib/isotope/isotope.pkgd.min.js"></script>
        <script src="./frontoffice/lib/lightbox/js/lightbox.min.js"></script>

        <!-- Template Javascript -->
        <script src="./frontoffice/js/main.js"></script>
    </body>
</html>