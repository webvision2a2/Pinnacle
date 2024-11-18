<?php
include '../../Controller/quizController.php' ; // Include quiz controller

$controller = new QuizController();
$quizzes = $controller->listQuizzes(); // Fetching all quizzes from the db
?>
<!DOCTYPE html>
<html lang="fr">
<head>
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
    <link href="template/lib/animate/animate.min.css" rel="stylesheet">
    <link href="template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="template/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="template/css/style.css" rel="stylesheet">

</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img class ='logo' src="template/img/LOGO 1 blue.png">
                    <h1 class="m-0">Pinnacle</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#" class="nav-item nav-link">Acceuil</a>
                        <a href="#" class="nav-item nav-link">à Propos</a>
                        <a href="#" class="nav-item nav-link">Evènements</a>
                        <a href="quiz.php" class="nav-item nav-link active">Quiz</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cours</a>
                            <div class="dropdown-menu m-0">
                                <a href="#" class="dropdown-item">Cours (Modules)</a>
                                <a href="#" class="dropdown-item">Videos</a>
                                <a href="#" class="dropdown-item">Ateliers</a>
                            </div>
                        </div>
                        <a href="#" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Commencer</a>
                </div>
            </nav>

        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                   <!--   <h1 class="text-white mb-4 animated slideInDown" >Welcome to the quiz</h1>    -->
                     
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->
    <!-- Quiz Section -->


    <div class="container my-5">
        <h1 class="text-center text-primary fw-bold mb-4">Les Quizzes Disponibles</h1>
        
        <div class="row">
            <?php foreach ($quizzes as $quiz): ?>
                <div class="col-md-6 mb-4">
                    <div class="service-item border rounded shadow-sm p-4 bg-white">
                        <h3 class="fw-semi-bold text-secondary"><?= htmlspecialchars($quiz['title']) ?></h3>
                        <p class="text-muted"><?= htmlspecialchars($quiz['description']) ?></p>
                        <small class="d-block text-dark mb-3">Fait par <?= htmlspecialchars($quiz['author']) ?> le <?= htmlspecialchars($quiz['creation_date']) ?></small>
                        <a class="btn btn-primary px-4 py-2 rounded-pill text-light" href="quizDetails.php?id=<?= $quiz['id'] ?>">Voir Quiz</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
 
      <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="template/lib/wow/wow.min.js"></script>
    <script src="template/lib/easing/easing.min.js"></script>
    <script src="template/lib/waypoints/waypoints.min.js"></script>
    <script src="template/lib/counterup/counterup.min.js"></script>
    <script src="template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="template/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="template/lib/lightbox/js/lightbox.min.js"></script>
    
    <script src="template/js/main.js"></script>
    
</body>
</html>