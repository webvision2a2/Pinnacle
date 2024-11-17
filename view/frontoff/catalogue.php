<?php
// catalogue.php

// Include the database connection and CRUD functions
include   '../../Models/Database.php';
include '../../Controller/CRUD.php';
// Enable error reporting for debugging (remove or comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all domaines from the database
$domaines = readdomaines(); // Ensure you have this function defined in CRUD.php

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Catalogue - Digital Agency</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- CSS Links -->
    <link href="Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="Templates/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #2C24CE;
            width: 100%; /* Ensure navbar is full width */
        }
        .navbar-brand img {
            max-height: 40px;
        }
        
        .domaine-card {
    background: #ffffff; /* White background for cards */
    border: 2px solid #007bff; /* Blue border */
    border-radius: 12px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
    padding: 20px; /* Padding inside the card */
    margin-bottom: 20px; /* Space between cards */
    text-align: center; /* Centered text */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: auto; /* Allow height to adjust based on content */
}

.domaine-card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

        .domaine-card img {
            width: 100%; /* Responsive image */
            height: auto; /* Maintain aspect ratio */
            max-height: 160px; /* Limit height for uniformity */
            object-fit: cover; /* Crop image to fit without stretching */
            border-radius: 10px; /* Rounded corners for images */
        }

        .domaine-card h4 {
            margin-top: 15px;
            color: #007bff; /* Brand color for titles */
            font-size: 1.6rem; /* Larger title font size */
        }

        .domaine-card p {
            margin-top: 10px;
            margin-bottom: auto;
            color: #555; /* Dark gray text for descriptions */
            font-size: 1rem; /* Standard description font size */
        }
        .btn-cours {
    background: linear-gradient(45deg, #007bff, #0056b3); /* Blue gradient */
    color: white;
    border-radius: 25px; /* Rounded corners */
    padding: 10px 20px; /* Comfortable padding */
    font-size: 1rem; /* Font size */
    text-decoration: none;
    transition: background 0.3s ease, transform 0.3s ease; /* Smooth transitions */
}

.btn-cours:hover {
    background: linear-gradient(45deg, #0056b3, #003d80); /* Darker gradient on hover */
    transform: translateY(-2px); /* Slight lift effect on hover */
}
       


h1 {
            color:#2C24CE;
            margin-bottom: 30px;
        }
        
        
        .footer {
            background-color: #2C24CE; /* Same color as cards */
            color: white; /* White text for contrast */
            padding: 30px 0;
            text-align: center;
        }
        
        /* Testimonial Section Styles */
        .testimonial-section {
            background-color: #f8f9fa; /* Light background for contrast */
            padding: 40px 20px;
            border-radius: 25px; /* Rounded corners */

        }
        
        .testimonial-item {
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        
        .testimonial-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .testimonial-item img {
            width: 65px; 
            height: 65px; 
        }
    </style>
</head>

<body>

      <!-- Navbar Start -->
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid"> <!-- Use container-fluid for full width -->
            <a href="" class="navbar-brand p-0">
                <img class='logo' src="img/LOGO 1 blue.png" alt="Logo">
                <h1 class="m-0">Pinnacle</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Accueil</a>
                    <a href="catalogue.php" class="nav-item nav-link  active">Catalogue</a>
                    <a href="#" class="nav-item nav-link">Entretien</a>
                    <a href="#" class="nav-item nav-link">Psychologie</a>
                    <a href="#" class="nav-item nav-link">Réseau</a>
                    <a href="#" class="nav-item nav-link">Événements</a>
                <a href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Se déconnecter</a>
            </div>
        </div> <!-- End of container-fluid -->
    </nav>
    <!-- Navbar End -->  
  
    <!-- Catalogue Content Start -->
   <div class='container py-5'>
       <h1 class='text-center'>Les domaines disponibles</h1>
        
       <?php if (!empty($domaines)): ?>
           <div class='row justify-content-around mt-4'>
               <?php foreach ($domaines as $domaine): ?>
                   <div class='col-md-4 mb-4'>
                       <!-- Domaine Card -->
                       <div class='domaine-card shadow-sm p-4 rounded text-center'>
                           <?php if (!empty($domaine['image'])) : ?>
                               <!-- Display image if available -->
                               <img src="<?php echo htmlspecialchars($domaine['image']); ?>" alt="<?php echo htmlspecialchars($domaine['name']); ?>" />
                           <?php else : ?>
                               <p>No Image Available</p>
                           <?php endif; ?>
                           <h4><?php echo htmlspecialchars($domaine['name']); ?></h4>
                           <p><?php echo htmlspecialchars($domaine['description']); ?></p>
                           <!-- Button to view course -->
                           <a href='cours.php'class='btn-cours'>Voir Cours</a>
                       </div>
                   </div> 
               <?php endforeach; ?>
           </div> 
       <?php else : ?>
           <p>Aucun domaine disponible.</p>
       <?php endif; ?>
   </div> 

      <!-- JavaScript Libraries -->
      <script src='Templates/vendor/jquery/jquery.min.js'></script> 
      <script src='Templates/vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
      
        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Contact<span></span></p>
                        <p><i class="fa fa-map-marker-alt me-3"></i>Esprit,Ariana soghra</p>
                        <p><i class="fa fa-phone-alt me-3"></i>24306909</p>
                        <p><i class="fa fa-envelope me-3"></i>Pinnacle@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Pinnacle</a>, All Right Reserved. 
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

</body>

</html>