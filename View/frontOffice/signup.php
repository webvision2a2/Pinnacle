<?php

require_once '../../controller/UserController.php';
require_once '../../controller/ProfileController.php';


$error = "";

$user = null;
$newUserId = null;

$userController = new UserController();
$profileController = new ProfileController();


if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {

        $faceId = null;
        if (isset($_POST['face_id']) && !empty($_POST['face_id'])) {
            $faceId = $_POST['face_id'];
        }
        $hashed_password = $_POST["password"];
        $date_creation = date('Y-m-d H:i:s');
        $user = new User(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $hashed_password,
            $_POST['role'],
            new DateTime($date_creation),
            0,
            $faceId
        );

        $newUserId = $userController->addUser($user, 'front');

        if ($newUserId) {
            if ($faceId != null) {

                $addFaceUrl = 'https://api-us.faceplusplus.com/facepp/v3/faceset/addface';
                $addFaceData = [
                    'api_key' => "Yt-Jl7lyIMnxqeix-Yvdz-rqrXpafWG_",
                    'api_secret' => "gVhY10PUviYgcejYFSyrcocah3nJmygn",
                    'faceset_token' => "7c116b608162a5cd58f738e10b8ccb93",
                    'face_tokens' => $faceId
                ];

                $options = [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($addFaceData)
                    ]
                ];
                $context = stream_context_create($options);
                $addFaceResult = file_get_contents($addFaceUrl, false, $context);

                if ($addFaceResult === FALSE) {
                    echo json_encode(['success' => false, 'message' => 'Failed to add face to FaceSet.']);
                }
            }
            $profileController->createProfile($newUserId);
        }


        /* if ($newUserId) {
            // Send confirmation email with token
            $userController->envoyerEmailConfirmation($newUserId);
            // Create a profile for the user
            

            echo "Inscription réussie. Veuillez vérifier votre e-mail.";
        } else {
            echo "Erreur lors de l'inscription.";
        } */
        header('Location: sent_verification_link.php');

    } else {
        $error = "Informations manquantes.";
    }
}

/* if (isset($_POST['id']) && isset($_POST['verification']) && $_POST['verification'] == '1') {
    $userId = $_POST['id'];
    
    // Call the controller method to verify the email
    if ($userController->verifyEmail($userId)) {
        echo "Votre compte a été vérifié avec succès. Vous pouvez maintenant vous connecter.";
    } else {
        echo "Ce lien de vérification est invalide ou votre compte est déjà vérifié.";
    }
} */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Signup - Pinnacle</title>
    <!-- Favicon -->
    <link href="Template/img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap and Custom Stylesheet -->
    <link href="Template/css/bootstrap.min.css" rel="stylesheet">
    <link href="Template/css/style.css" rel="stylesheet">
    <style>
        #video,
        #canvas {
            position: absolute;
            /* Absolute positioning to fit the container */
            top: 50%;
            /* Center vertically */
            left: 50%;
            /* Center horizontally */
            transform: translate(-50%, -50%);
            border-radius: 25px;
            /* Rounds the corners to match the container */
            z-index: 1000;
            border: 2px solid #1c5739;
            transition: 0.6s ease;
            animation: movingBorder 2s infinite ease;
            /* Apply the animation */
        }

        @keyframes movingBorder {

            0%,
            100% {
                border-color: #1c5799;
                /* Starting color */
                box-shadow: 0 0 15px #1c5799;
            }

            5%,
            95% {
                border-color: #1a639f;
                box-shadow: 0 0 16px #1a639f;
            }

            10%,
            90% {
                border-color: #176ea9;
                box-shadow: 0 0 17px #176ea9;
            }

            15%,
            85% {
                border-color: #1579af;
                box-shadow: 0 0 18px #1579af;
            }

            20%,
            80% {
                border-color: #1384b5;
                box-shadow: 0 0 19px #1384b5;
            }

            25%,
            75% {
                border-color: #108fbd;
                box-shadow: 0 0 20px #108fbd;
            }

            30%,
            70% {
                border-color: #0e9ac7;
                box-shadow: 0 0 21px #0e9ac7;
            }

            35%,
            65% {
                border-color: #0ba5d3;
                box-shadow: 0 0 22px #0ba5d3;
            }

            40%,
            60% {
                border-color: #07b0df;
                box-shadow: 0 0 23px #07b0df;
            }

            50% {
                border-color: #04bbeb;
                box-shadow: 0 0 25px #04bbeb;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white d-flex flex-column align-items-center justify-content-center vh-100">
        <!-- Logo et Titre Centrés -->
        <div class="card p-5 shadow-lg border-0" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <h1 class="m-0" style="color: #2C24CE ;"><img class="logo" src="Template/img/LOGO 1 blue.png"
                        alt="Pinnacle Logo" style="max-width: 45px;">Pinnacle</h1>
            </div>


            <h3 class="text-center mb-4">Créer un Compte</h3>

            <video id="video" width="640" height="480" autoplay hidden></video>
            <canvas id="canvas" width="640" height="480" hidden></canvas>

            <form id="signupForm" action="" method="post">

                <input type="hidden" name="role" value="2">
                <div class="form-group mb-3">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom">
                    <p id="p_nom"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prenom">
                    <p id="p_prenom"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email">
                    <p id="p_email"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Créez un mot de passe">
                    <p id="p_password"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Confirmation du Mot de Passe</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Confirmer le mot de passe">
                    <p id="p_confirmpassword"></p>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Configuration du Face ID</label>
                    <input type="hidden" name="face_id" id="face_id">
                    <button type="button" id="registerFace" class="btn btn-secondary btn-block w-100 rounded-pill"
                        onclick="startFaceRecognition()">Configurer Face ID </button>
                </div>

                <button type="submit" class="btn btn-primary btn-block w-100 rounded-pill">S'inscrire</button>


                <div class="text-center mt-3">
                    <p class="mb-0">Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
                </div>
            </form>
        </div>
    </div>


    <script src="../backOffice/js/addUser.js"></script>

    <script src="face_recognition.js"></script>




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