<?php

include_once '../../Model/Domaine.php';
include_once '../../Model/Cours.php';
include_once '../../Controller/CRUD.php';
include_once '../../Model/Rating.php';
include_once '../../config_zeineb.php';


session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the Domaine ID from the query string
$domaine_id = isset($_GET['domaine_id']) ? intval($_GET['domaine_id']) : 0;

// Fetch courses for the selected domaine
$cours = getCoursByDomaineId($domaine_id);
$domaine = getDomaineById($domaine_id); // Get domain details for display

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Liste des Cours</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- CSS Links -->
    <link href="../../Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../Templates/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f8f9fa;
        }

        h1 {
            color: #2C24CE;
            margin: 50px 0 20px;
            /* Increased margin at the top for spacing */
            text-align: center;
        }

        .container {
            margin: 20px;
        }

        .card {
            margin: 15px 0;
            /* Space between cards */
            border: 2px solid #007bff;
            /* Blue border */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            background-color: white;
            /* White background for cards */
        }

        .card-header {
            background-color: white;
            /* Change header color to white */
            color: #2C24CE;
            /* Change text color to blue for course name */
            font-size: 1.5rem;
            text-align: center;
            padding: 10px;
        }

        .card-body {
            padding: 15px;
        }

        .btn-cours {
            background: linear-gradient(45deg, #007bff, #0056b3);
            /* Blue gradient */
            color: white;
            border-radius: 25px;
            /* Rounded corners */
            padding: 10px 20px;
            /* Comfortable padding */
            font-size: 0.9rem;
            /* Smaller font size */
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            /* Smooth transitions */
        }

        .btn-cours:hover {
            background-color: orange;
            /* Change to orange on hover */
            transform: translateY(-2px);
            /* Slight lift effect on hover */
        }

        .footer {
            background-color: #2C24CE;
            /* Same color as cards */
            color: white;
            /* White text for contrast */
            padding: 30px 0;
            text-align: center;
        }

        .star-rating {
            cursor: pointer;
            direction: rtl;
        }

        .star {
            font-size: 24px;
            /* Star size */
            color: #ccc;
            /* Star color */
            margin-right: 5px;
        }

        .star:hover,
        .star:hover~.star {
            color: #f0d700;
            /* Highlight color */
        }

        .selected {
            color: #f0d700;
        }
    </style>
</head>

<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2C24CE;">
        <div class="container-fluid">
            <a href="" class="navbar-brand p-0">
                <img class='logo' src="img/LOGO 1 blue.png" alt="Logo" style="max-height: 40px;">
                <h1 class="m-0" style="color: white;">Pinnacle</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars" style="color: white;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="../frontOffice_zeineb/Template/index.php" class="nav-item nav-link"
                        style="color: white;">Accueil</a>
                    <a href="catalogue.php" class="nav-item nav-link" style="color: white;">Catalogue</a>
                    <a href="../frontOfficeChams/quiz.php" class="nav-link text-white">Entretien</a>
                    <a href="../frontofficeahmed/main.php" class="nav-item nav-link">Societes</a>
                    <a href="../frontofficeahmed/main2.php" class="nav-item nav-link text-white">Stages</a>
                    <a href="../frontoffice moemen/topicsPage.php" class="nav-item nav-link text-white">Psychologie</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Evenement<span
                                class="arrow">&#9660;</span></a>
                        <div class="dropdown-menu">
                            <a href="../FrontOffice/eventdispo.php" class="dropdown-item">Nos événements</a>
                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#addEventModal">Ajouter un événement</a>
                        </div>
                    </div>
                    <a href="../frontOffice_zeineb/Template/profile.php" class="nav-item nav-link text-white">Profil</a>
                    <div class="navbar-nav">
                        <button id="speakButton" class="nav-item nav-link btn btn-link" style="color: white;">
                            <i class="fas fa-volume-up"></i> Lire à voix haute
                        </button>
                    </div>
                    <a href="../frontOffice_zeineb/logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se
                        Déconnecter</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Catalogue Content Start -->
    <div class="container">
        <h1>''</h1>
        <h1>Liste des Cours pour <?php echo htmlspecialchars($domaine['nom']); ?></h1>

        <div class="row">
            <?php if (!empty($cours)): ?>
                <?php foreach ($cours as $course): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header text-center">
                                <h5><?php echo htmlspecialchars($course['nom']); ?></h5> <!-- Course name styled -->
                            </div>
                            <div class="card-body text-center">
                                <p><strong>Domaine:</strong> <?php echo htmlspecialchars($domaine['nom']); ?></p>
                                <?php
                                $ratingModel = new Rating();
                                $userid = $_SESSION["id"];
                                $ratingValue = $ratingModel->getUserCourseRating($userid, $course['id_cours']);
                                ?>

                                <div class="star-rating" data-course-id="<?php echo $course['id_cours']; ?>">
                                    <span class="star" data-rating="5">&#9733;</span>
                                    <span class="star" data-rating="4">&#9733;</span>
                                    <span class="star" data-rating="3">&#9733;</span>
                                    <span class="star" data-rating="2">&#9733;</span>
                                    <span class="star" data-rating="1">&#9733;</span>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var starContainers = document.querySelectorAll('.star-rating');

                                        starContainers.forEach(function (container) {
                                            var courseId = container.getAttribute('data-course-id');
                                            var stars = container.querySelectorAll('.star');
                                            var userId = <?php echo json_encode($userid); ?>; // ID utilisateur

                                            // Charger la note actuelle
                                            loadCourseRating(courseId, stars);

                                            // Ajouter des événements de clic
                                            stars.forEach(function (star) {
                                                star.addEventListener('click', function () {
                                                    var ratingValue = parseInt(star.getAttribute('data-rating'));
                                                    saveCourseRating(courseId, userId, ratingValue, stars);
                                                });
                                            });
                                        });

                                        function loadCourseRating(courseId, stars) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.open("GET", '../../Controller/RatingController.php?action=get&course_id=' + courseId + '&user_id=<?php echo $userid; ?>', true);
                                            xhr.onreadystatechange = function () {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    var response = JSON.parse(xhr.responseText);
                                                    updateStarDisplay(response.rating, stars);
                                                }
                                            };
                                            xhr.send();
                                        }

                                        function saveCourseRating(courseId, userId, ratingValue, stars) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.open("POST", '../../Controller/RatingController.php', true);
                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                            xhr.onreadystatechange = function () {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    var response = JSON.parse(xhr.responseText);
                                                    updateStarDisplay(response.rating, stars);
                                                    console.log("stars: ", stars);
                                                    console.log("response rating: ", response.rating);
                                                }
                                            };
                                            xhr.send("action=save&course_id=" + courseId + "&user_id=" + userId + "&rating=" + ratingValue);

                                        }

                                        function updateStarDisplay(rating, stars) {
                                            stars.forEach(function (star) {
                                                var ratingValue = parseInt(star.getAttribute('data-rating'));
                                                if (ratingValue <= rating) {
                                                    star.classList.add('selected');
                                                } else {
                                                    star.classList.remove('selected');
                                                }
                                            });
                                        }
                                    });
                                </script>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var stars = document.querySelectorAll('.star');
                                        var courseId = <?php echo json_encode($course['id_cours']); ?>;
                                        var user_id = <?php echo json_encode($userid); ?>;
                                        console.log("user id: " + user_id);
                                        stars.forEach(function (star) {
                                            star.addEventListener('click', function () {
                                                var ratingValue = parseInt(star.getAttribute('data-rating'));

                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", '../../Controller/RatingController.php', true);
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.onreadystatechange = function () {
                                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                                        var response = JSON.parse(xhr.responseText);
                                                        updateStarDisplay(response.rating);
                                                        location.reload();
                                                    }
                                                };
                                                xhr.send("course_id=" + courseId + "&rating=" + ratingValue + "&user_id=" + user_id);
                                            });
                                        });
                                        function updateStarDisplay(rating) {
                                            stars.forEach(function (star) {
                                                var ratingValue = parseInt(star.getAttribute('data-rating'));
                                                console.log(star.classlist)
                                                if (ratingValue <= rating) {
                                                    star.classList.add('selected');
                                                } else {
                                                    star.classList.remove('selected');
                                                }
                                                console.log(star, star.classList);
                                            });
                                        }
                                    });
                                </script>


                                <a href="<?php echo htmlspecialchars($course['fichier']); ?>" target="_blank"
                                    class="btn btn-cours">Télécharger</a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun cours disponible pour ce domaine.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <p>© 2023 Pinnacle. Tous droits réservés.</p>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- JS Links -->
    <script src="../../Templates/vendor/jquery/jquery.min.js"></script>
    <script src="../../Templates/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>