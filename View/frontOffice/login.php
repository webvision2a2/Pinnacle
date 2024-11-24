<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (intval($_SESSION["role"]) === 2) {
        header("location: Template/index.php");
    } else {
        header("location: ../backOffice/users.php");
    }
    exit;
}

// Include config file
include(__DIR__ . '/../../config.php');
$pdo = config::getConnexion();

$email = $password = $nom = $prenom = $role = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "L'email est obligatoire.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "L'email doit être valide.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Le mot de passe est obligatoire.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, nom, prenom, password, role FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch();
                    $id = $row["id"];
                    $nom = $row["nom"];
                    $prenom = $row["prenom"];
                    $hashed_password = $row["password"];
                    $role = intval($row["role"]);

                    if ($password === $hashed_password)  {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["nom"] = $nom;
                        $_SESSION["prenom"] = $prenom;
                        $_SESSION["role"] = $role;

                        if ($role === 2) {
                            header("location: Template/index.php");
                        } else {
                            header("location: ../backOffice/users.php");
                        }
                        exit;
                    } else {
                        $login_err = "Email ou mot de passe invalide.";
                    }
                } else {
                    $login_err = "Email ou mot de passe invalide.";
                }
            } else {
                echo "Une erreur est survenue. Veuillez réessayer plus tard.";
            }

            unset($stmt);
        }
    }

    unset($pdo);
}
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
            <h3 class="text-center mb-4">Connexion à Pinnacle</h3>
            <?php if (!empty($login_err)): ?>
                <div class="alert alert-danger"><?php echo $login_err; ?></div>
            <?php endif; ?>

            <form id="loginForm" action="login.php" method="POST">

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email">
        <span class="text-danger"><?php echo $email_err; ?></span>
    </div>

    <div class="form-group mb-3">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe">
        <span class="text-danger"><?php echo $password_err; ?></span>
    </div>

    <button id="submit" type="submit" class="btn btn-primary btn-block w-100 rounded-pill">Se connecter</button>
    <div class="text-center mt-3">
        <p class="mb-0">Vous n'avez pas de compte ? <a href="signup.php">S'inscrire</a></p>
    </div>
</form>
        </div>
    </div>

    <!-- <script src="js/login.js"></script> -->

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
