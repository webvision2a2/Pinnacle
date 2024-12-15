

<?php
include '../../config_zeineb.php';
require_once '../../controller/UserController.php';

session_start();
$controller = new UserController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - Pinnacle</title>
    <!-- Favicon -->
    <link href="Template/img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap and Custom Stylesheet -->
    <link href="Template/css/bootstrap.min.css" rel="stylesheet">
    <link href="Template/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white d-flex flex-column align-items-center justify-content-center vh-100">
        <!-- Logo et Titre Centrés -->
        <div class="text-center mb-4">
            <h1 class="m-0" style="color: #2C24CE ;"><img class="logo" src="Template/img/LOGO 1 blue.png" alt="Pinnacle Logo" style="max-width: 45px;">Pinnacle</h1>
        </div>

        <div class="card p-5 shadow-lg border-0" style="max-width: 400px; width: 100%;">
            <form id="reset-password-form" method="POST" autocomplete="off" novalidate="true">

                <div class="form-group mb-3">
                    <label for="password">Nouveau Mot de Passe:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Saisir un mot de passe">
                    <p id="p_password"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="confirm_password">Confirmation du Nouveau Mot de passe:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmer le mot de passe">
                    <p id="p_confirmpassword"></p>
                </div>
                
                <button id="submit" type="submit" class="btn btn-primary btn-block w-100 rounded-pill">Réinitialiser mot de passe</button>
            </form>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Template/lib/wow/wow.min.js"></script>
    <script src="Template/lib/easing/easing.min.js"></script>
    <script src="Template/lib/waypoints/waypoints.min.js"></script>
    <script src="Template/lib/counterup/counterup.min.js"></script>
    <script src="Template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="Template/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="Template/lib/lightbox/js/lightbox.min.js"></script>
    <!-- Template Javascript -->


</body>
</html> 


<?php
// Retrieve the token from the URL
$token = $_GET['token'] ?? null;

if (!$token) {
    echo 'Token is missing.';
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $password = $_POST['password'] ?? null;
    $confirmPassword = $_POST['confirm_password'] ?? null;

    // Validate form data
    if (!$password || !$confirmPassword) {
        echo 'Please fill in all fields.';
        exit();
    }

    if ($password === $confirmPassword) {
        $currentPasswordHash = $controller->getCurrentPasswordHashByToken($token);
        if (password_verify($password, $currentPasswordHash)) {
            echo "Passwords cannot be the same.";
        } else {
            $resetStatus = $controller->resetPassword($token, $password);
            if ($resetStatus) {
                echo "Password updated successfully.";
            } else {
                echo "An error occurred during the password reset.";
            }
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>



