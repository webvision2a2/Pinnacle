<?php
    include_once '../../Controller/topicController.php';
    $topicController = new TopicController();
    $topic = $topicController->getTopicById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Read Topic</title>

        <!-- Favicon -->
        <link href="./frontoffice/img/favicon.ico" rel="icon">

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



        <link rel="stylesheet" href="stylereadTopic.css">
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
                <a href="topicsPage.php" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Topics List</a>
                
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="wow fadeInUp" data-wow-delay="0.3s">
                                <div class="mt-4">
                                    <div class="card">
                                        <div class="card-title">
                                            <h1 class="text-center mt-4"><?php echo $topic['title'];?></h1>
                                        </div>
                                        <div class="card-image container text-center">
                                            <img src="<?php echo $topic['image'];?>">
                                        </div>
                                        <div class="card-body text-center">
                                            <p><?php echo $topic['description'];?></p>
                                            <p><?php echo $topic['content'];?></p>
                                            <a href="<?php echo $topic['video_link'];?>">Video link</a>
                                        </div>
                                    </div>

                                    <div class="comments-section mt-5">
                                        <?php
                                        require_once '../../Controller/commentController.php';	

                                        $topid = $_GET['id'] ?? null;

                                        $commentController = new CommentController();

                                        $comments = $commentController->getComments($topid);

                                        // Affichage du nombre de commentaires
                                        $num_comments = count($comments);
                                        
                                        echo "<p><strong>Nombre de commentaires :</strong> $num_comments</p>";

                                        foreach ($comments as $comment):?>
                                            
                                            <br>
                                            <div class="comment">
                                                <p><strong>Utilisateur :</strong> <?php echo $comment['content']  ?> </p>
                                                <p class="meta"><em>Publié le <?php echo $comment['datec'] ?></em> </p>
                                                <p class="meta">
                                                    <a href="updateComment.php?id=<?php echo $comment['id']?>&topid=<?php echo $topid ?>">Modifier</a> |
                                                    <a href="deleteComment.php?id=<?php echo $comment['id']?>&topid=<?php echo $topid ?>">Supprimer</a>
                                                </p>
                                            </div>
                                    
                                        
                                            <?php endforeach;?>

                                        <form action="addComment.php?topid=<?php echo $_GET['id'] ;?>" method="POST" id="com">
                                            <br><br><br>
                                            <h4>Ajouter un commentaire</h4>
                                            <textarea class="form-control" name="content" rows="4" placeholder="Enter your comment" id="commentaire"></textarea>
                                            <br>
                                            <button class="btn btn-primary w-100 py-3" type="submit">Publier</button>
                                        </form>
                                    </div>
                                    <br>
                                    <p style="color: red;" id="erreur" align="center"></p>
                                </div>

                        
                            </div>
                        </div>
                    </div>
            <script src="scriptcomment.js"></script>   
            </div>        
            <!-- Footer Start -->
            <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5 px-lg-5">            
                </div>
            </div>
            <!-- Footer End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>        


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



