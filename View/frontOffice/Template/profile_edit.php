
<?php
session_start();

require_once '../../../controller/ProfileController.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 2 ) {
    header("location: ../login.php");
    exit;
}


$profile = null;

$profileController = new ProfileController();
include_once '../../../config.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo_profil'])) {
    if(isset($_POST['submit_profile2'])){

    // Check if a file was uploaded successfully
    if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/uploads/";

        // Ensure upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the uploads directory
        $uploadedFilePath = $uploadDir . basename($_FILES['photo_profil']['name']);
        if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $uploadedFilePath)) {
            // Update the database
            try {
                include_once '../../../config.php'; // Adjust path to include database connection
                $pdo = config::getConnexion();

                $sql = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':photo_profil' => 'uploads/' . basename($_FILES['photo_profil']['name']),
                    ':user_id' => $_SESSION['id']
                ]);

                // Redirect to the same page to reflect the updated profile
                header("Location: profile.php");
                exit;
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Failed to move uploaded file.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">File upload error: ' . $_FILES['photo_profil']['error'] . '</div>';
    }
}
}

$current_user = $profileController->getProfileByUserId($_SESSION['id']);


if(isset($_POST['submit'])){
    echo 'updating';
    if (isset($_POST["domaine"]) && isset($_POST["occupation"]) && isset($_POST["telephone"]) && isset($_POST["age"])) {
        if (!empty($_POST["domaine"]) && !empty($_POST["occupation"]) && !empty($_POST["telephone"]) && !empty($_POST["age"])) {
            $profile = new Profile(
                $current_user['id'],
                $_SESSION['id'],
                $_POST['domaine'],
                $_POST['occupation'],
                $_POST['age'],
                $_POST['telephone'],
                $current_user['photo_profil']
            );

            $profileController->updateProfile($_SESSION['id'], $profile);
            echo "<p class='success'>Profil mis à jour avec succès.</p>";
            header('Location:profile.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profil</title>
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
        .button_modifier {
            background-color: #FBA504;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
        }

        .button_modifier:hover {
            background-color: #0056b3;
        }

        .rounded-circle {
            border: 2px solid #007bff;
        }

        .text-secondary {
            font-size: 14px;
        }

        .font-size-sm {
            font-size: 12px;
        }
    </style>
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
        <div class="container-xxl position-relative p-0" style="backgroung-color: #1e1ed8;">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0"  >
                <a href="" class="navbar-brand p-0">
                    <img class ='logo' src="img/LOGO 1 blue.png" style="max-width: 45px;">
                    <h1 class="m-0 " style="margin-right: 20px;" >Pinnacle</h1>
                </a>
                
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="index.php" class="nav-item nav-link text-white">Acceuil</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">Catalogue</a>
                    <div class="dropdown-menu m-0">
                        <a href="team.php" class="dropdown-item">Notre Equipe</a>
                        <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                        <a href="404.php" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="service.php" class="nav-item nav-link text-white">Entretients</a>
                <a href="project.php" class="nav-item nav-link text-white">Stages</a>
                <a href="project.php" class="nav-item nav-link text-white">Psychologie</a>
                <a href="project.php" class="nav-item nav-link text-white">Evenements</a>
                <a href="profile.php" class="nav-item nav-link text-white active">Profil</a>
            </div>
                <a href="../logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
            </div>
        </div>
    </nav>
</div>
        <!-- Navbar End -->

        <!-- Profile Section -->
        <div class="container-xxl bg-primary hero-header">
    <div class="container px-lg-5">
        <div class="container py-5">
            <div class="main-body">
                <?php
                if (isset($_POST['id'])) {
                    $id = $_POST['id'] ;
                    echo 'mon id est:'.$id;
                    $profile = $profileController->showProfile($id);
                ?>
                <div class="row">
                    <!-- Left Column: Profile Picture and Upload -->
                    <div class="col-md-4 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <img id="profile-picture-preview" 
                                    src="uploads/<?php echo basename($profile['photo_profil']); ?>" 
                                    alt="Profile Picture" 
                                    class="rounded-circle photo_profil mb-3" width="150">
                                <h4><?php echo $_SESSION["nom"] . " " . $_SESSION["prenom"]; ?></h4>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <label for="fileInput" class="form-label">Changer la photo de profil</label>
                                    <input type="file" name="photo_profil" id="fileInput" class="form-control mb-2">
                                    <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                                    <button type="submit" name="submit_profile2" class="btn btn-primary">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Profile Information -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form id="UpdateForm" action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    
                                    <!-- Domaine -->
                                    <div class="mb-3">
                                        <label for="domaine" class="form-label">Domaine</label>
                                        <input type="text" id="domaine" name="domaine" 
                                            class="form-control" 
                                            placeholder="Domaine" 
                                            value="<?php echo isset($_POST['domaine']) ? htmlspecialchars($_POST['domaine']) : $profile['domaine']; ?>">
                                        <span class="error text-danger" id="domaine_err"></span>
                                    </div>

                                    <!-- Occupation -->
                                    <div class="mb-3">
                                        <label for="occupation" class="form-label">Occupation</label>
                                        <input type="text" id="occupation" name="occupation" 
                                            class="form-control" 
                                            placeholder="Occupation" 
                                            value="<?php echo isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation']) : $profile['occupation']; ?>">
                                        <span class="error text-danger" id="occupation_err"></span>
                                    </div>

                                    <!-- Age -->
                                    <div class="mb-3">
                                        <label for="age" class="form-label">Âge</label>
                                        <input type="number" id="age" name="age" 
                                            class="form-control" 
                                            placeholder="Âge" 
                                            value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : $profile['age']; ?>">
                                        <span class="error text-danger" id="age_err"></span>
                                    </div>

                                    <!-- Telephone -->
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="text" id="telephone" name="telephone" 
                                            class="form-control" 
                                            placeholder="Numéro de téléphone" 
                                            value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : $profile['telephone']; ?>">
                                        <span class="error text-danger" id="telephone_err"></span>
                                    </div>
                                    
                                    <!-- Save and Cancel Buttons -->
                                    <div class="text-end">
                                        <button type="submit" name="submit" class="btn btn-primary">Enregistrer</button>
                                        <a href="profile.php" class="btn btn-secondary">Annuler</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                    echo "<div class='alert alert-danger'>ID is not set</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

                
            </div>
        </div>
    </div>
</div>
        <!-- Profile Section End -->

    </div>

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
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Quick Link<span></span></p>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Gallery<span></span></p>
                        <div class="row g-2">
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-1.jpg" alt="Image">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-2.jpg" alt="Image">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-3.jpg" alt="Image">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-4.jpg" alt="Image">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-5.jpg" alt="Image">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" src="img/portfolio-6.jpg" alt="Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Newsletter<span></span></p>
                        <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulpu</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="js/updateProfile.js"></script>


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

    <script>
        /* const previewImage = () => {
            let file = document.querySelector('#fileInput');
            let photo_profil = document.querySelector(".photo_profil");
            let message = document.querySelector(".message");
            let submit = document.querySelector(".submit");

            photo_profil.src = window.URL.createObjectURL(file.file[0]);
            let regex = new RegExp("[^.]+$");
            fileExtension = file.value.match(regex);
            if(fileEctension == "jpeg" || fileEctension == "jpg" || fileEctension == "png" ){
                submit.style.display="block";
                message.innerHTML="";
            }else{
                photo_profil.src = "img/error.png"
                submit.style.display="none";
                message.innerHTML="<b>." + fileExtension + "<b> file is not allowed.<br/>Choose a .jpg or .png file only";
            }
        } */

        const previewImage = () => {
            let file = document.querySelector('#fileInput'); 
            let photoProfil = document.querySelector(".file");
            let message = document.querySelector(".message");
            let submit = document.querySelector(".submit");

            if (file.files && file.files[0]) {
                // Preview the selected file
                photoProfil.src = window.URL.createObjectURL(file.files[0]);

                // Extract file extension (case-insensitive match)
                let regex = /[^.]+$/;
                let fileExtension = file.value.match(regex)?.[0].toLowerCase();

                // Check allowed extensions
                if (fileExtension === "jpeg" || fileExtension === "jpg" || fileExtension === "png") {
                    submit.style.display = "block";
                    message.innerHTML = "";
                } else {
                    photoProfil.src = "img/error.png";
                    submit.style.display = "none";
                    message.innerHTML = `<b>.${fileExtension}</b> file is not allowed.<br/>Choose a .jpg or .png file only.`;
                }
            } else {
                photoProfil.src = "img/default.png"; // Fallback to default image
                message.innerHTML = "No file selected.";
                submit.style.display = "none";
            }
        };

    </script>
</body>

</html>