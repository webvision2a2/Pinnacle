<?php
include_once '../../Models/Domaine.php';
include_once '../../Models/Cours.php';
include_once '../../Controller/CRUD.php';
include_once 'C:\xampp\htdocs\validation 2\config.php';

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
            margin: 50px 0 20px; /* Increased margin at the top for spacing */
            text-align: center;
        }
        .container {
            margin: 20px;
        }
        .card {
            margin: 15px 0; /* Space between cards */
            border: 2px solid #007bff; /* Blue border */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            background-color: white; /* White background for cards */
        }
        .card-header {
            background-color: white; /* Change header color to white */
            color: #2C24CE; /* Change text color to blue for course name */
            font-size: 1.5rem;
            text-align: center;
            padding: 10px;
        }
        .card-body {
            padding: 15px;
        }
        .btn-cours {
            background: linear-gradient(45deg, #007bff, #0056b3); /* Blue gradient */
            color: white;
            border-radius: 25px; /* Rounded corners */
            padding: 10px 20px; /* Comfortable padding */
            font-size: 0.9rem; /* Smaller font size */
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transitions */
        }
        .btn-cours:hover {
            background-color: orange; /* Change to orange on hover */
            transform: translateY(-2px); /* Slight lift effect on hover */
        }
        .footer {
            background-color: #2C24CE; /* Same color as cards */
            color: white; /* White text for contrast */
            padding: 30px 0;
            text-align: center;
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
                <a href="index.php" class="nav-item nav-link" style="color: white;">Accueil</a>
                <a href="catalogue.php" class="nav-item nav-link" style="color: white;">Catalogue</a>
                <a href="#" class="nav-item nav-link" style="color: white;">Entretien</a>
                <a href="#" class="nav-item nav-link" style="color: white;">Psychologie</a>
                <a href="#" class="nav-item nav-link" style="color: white;">Réseau</a>
                <a href="#" class="nav-item nav-link" style="color: white;">Événements</a>
                <a href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block" style="color:white;background-color:#0056b3;">Se déconnecter</a>
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
                            <a href="<?php echo htmlspecialchars($course['fichier']); ?>" target="_blank" class="btn btn-cours">Télécharger</a>
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