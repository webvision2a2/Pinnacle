<?php
require_once '../../controller/StageController.php';
require_once '../../controller/CandidatureController.php';
require_once '../../config.php'; // Inclure votre fichier config pour la connexion à la base de données

$db = config::getConnexion(); // Obtenir l'objet PDO pour la connexion

if (isset($_GET['id'])) {
    $id_stage = $_GET['id']; // Récupérer l'ID du stage depuis l'URL
} else {
    echo "<p>Stage ID manquant.</p>";
    exit();
}

// Si le formulaire est soumis
if (isset($_POST['submit'])) {
    // Récupérer les informations du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];
    $cv = $_FILES['cv']; // Gestion du fichier CV

    if ($cv['error'] == 0) {
        $cv_name = $cv['name'];
        $cv_tmp_name = $cv['tmp_name'];
        $cv_dir = 'cv/';
        
        // Vérifier si le répertoire existe, sinon le créer
        if (!file_exists($cv_dir)) {
            mkdir($cv_dir, 0777, true);
        }

        $cv_path = $cv_dir . basename($cv_name);
        move_uploaded_file($cv_tmp_name, $cv_path);

        // Insertion des informations dans la base de données
        $stmt = $db->prepare("INSERT INTO candidatures (nom, prenom, numero, email, cv, id_stage) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $prenom, $numero, $email, $cv_path, $id_stage])) {
            echo "<p>Candidature soumise avec succès !</p>";
        } else {
            echo "<p>Erreur lors de la soumission de la candidature.</p>";
        }
    } else {
        echo "<p>Erreur lors du téléchargement du CV.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>DGital - Formulaire de Candidature</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Candidature au stage" name="keywords">
    <meta content="Soumettez votre candidature pour un stage." name="description">
    
    <!-- Favicon et autres liens -->
    <link href="img/favicon.ico" rel="icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">

        <!-- Navbar Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="m-0">DGital</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="main.php" class="nav-item nav-link">Sociétés</a>
                        <a href="main2.php" class="nav-item nav-link">Stages</a>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Get Started</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Hero Section Start -->
        <div class="container-xxl py-5 bg-primary hero-header">
            <div class="container my-5 py-5 px-lg-5">
                <div class="row g-5 py-5">
                    <div class="col-12 text-center">
                        <h1 class="text-white animated slideInDown">Postuler au Stage</h1>
                        <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Section End -->

        <!-- Formulaire de Candidature -->
        <div class="container py-5 px-lg-5">
            <form align="center" action="" method="POST" id="candidatureForm" enctype="multipart/form-data">
                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" />
                    <div id="nom_message" class="invalid-feedback"></div>
                </div>
                
                <!-- Prénom -->
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" />
                    <div id="prenom_message" class="invalid-feedback"></div>
                </div>
                
                <!-- Numéro de téléphone -->
                <div class="mb-3">
                    <label for="numero" class="form-label">Numéro de téléphone :</label>
                    <input type="text" class="form-control" id="numero" name="numero" />
                    <div id="numero_message" class="invalid-feedback"></div>
                </div>
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" />
                    <div id="email_message" class="invalid-feedback"></div>
                </div>
                
                <!-- CV -->
                <div class="mb-3">
                    <label for="cv" class="form-label">Télécharger votre CV :</label>
                    <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" />
                    <div id="cv_message" class="invalid-feedback"></div>
                </div>
                
                <!-- Soumettre -->
                <button type="submit" class="btn btn-success" name="submit" id="submitButton">Soumettre Candidature</button>
                
                <div class="text-center mt-4">
                    <a href="stageDetails.php?id=<?= $id_stage ?>" class="btn btn-primary">Retour aux détails du stage</a>
                </div>
            </form>
        </div>

    </div>
    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Contact</p>
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
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        document.getElementById("candidatureForm").addEventListener("submit", function(event) {
        let isValid = true;

        // Récupérer les éléments DOM
        const nom = document.getElementById("nom");
        const prenom = document.getElementById("prenom");
        const numero = document.getElementById("numero");
        const email = document.getElementById("email");
        const cv = document.getElementById("cv");

        // Validation du nom
        if (nom.value.length < 2) {
            document.getElementById("nom_message").innerHTML = "Le nom doit contenir au moins 2 caractères.";
            nom.classList.add("is-invalid");
            isValid = false;
        } else {
            nom.classList.remove("is-invalid");
            nom.classList.add("is-valid");
            document.getElementById("nom_message").innerHTML = "Correct";
        }

        // Validation du prénom
        if (prenom.value.length < 2) {
            document.getElementById("prenom_message").innerHTML = "Le prénom doit contenir au moins 2 caractères.";
            prenom.classList.add("is-invalid");
            isValid = false;
        } else {
            prenom.classList.remove("is-invalid");
            prenom.classList.add("is-valid");
            document.getElementById("prenom_message").innerHTML = "Correct";
        }

        // Validation du numéro de téléphone
        const numeroPattern = /^\d{8}$/; // Vérifier un numéro à 8 chiffres
        if (!numeroPattern.test(numero.value)) {
            document.getElementById("numero_message").innerHTML = "Le numéro de téléphone doit contenir 8 chiffres.";
            numero.classList.add("is-invalid");
            isValid = false;
        } else {
            numero.classList.remove("is-invalid");
            numero.classList.add("is-valid");
            document.getElementById("numero_message").innerHTML = "Correct";
        }

        // Validation de l'email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value)) {
            document.getElementById("email_message").innerHTML = "L'email doit être dans un format valide.";
            email.classList.add("is-invalid");
            isValid = false;
        } else {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            document.getElementById("email_message").innerHTML = "Correct";
        }

        // Validation du fichier CV
        if (cv.files.length === 0) {
            document.getElementById("cv_message").innerHTML = "Vous devez télécharger un CV.";
            cv.classList.add("is-invalid");
            isValid = false;
        } else {
            const validExtensions = [".pdf", ".doc", ".docx"];
            const fileExtension = cv.value.split('.').pop().toLowerCase();
            if (!validExtensions.includes('.' + fileExtension)) {
                document.getElementById("cv_message").innerHTML = "Le fichier doit être au format PDF, DOC ou DOCX.";
                cv.classList.add("is-invalid");
                isValid = false;
            } else {
                cv.classList.remove("is-invalid");
                cv.classList.add("is-valid");
                document.getElementById("cv_message").innerHTML = "Correct";
            }
        }

        // Si une validation échoue, empêcher la soumission du formulaire
        if (!isValid) {
            event.preventDefault();
        }
    });

    </script>
</body>

</html>
