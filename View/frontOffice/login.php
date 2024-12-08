<!-- <?php
/* session_start();

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

$email = $password = $nom = $prenom = $role = $verification = "";
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
        $sql = "SELECT id, nom, prenom, password, role, verification FROM users WHERE email = :email";

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
                    $verification = $row['verification'];

                    if (password_verify($password, $hashed_password))  {
                        if($verification == 1){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["nom"] = $nom;
                            $_SESSION["prenom"] = $prenom;
                            $_SESSION["role"] = $role;
                            $_SESSION["verification"] = $verification;

                            if ($role === 2) {
                                header("location: Template/index.php");
                            } else {
                                header("location: ../backOffice/users.php");
                            }
                            exit;
                        }
                        else{
                            $login_err = "Inscription non validé.";
                        }
                    } else {
                        $login_err = "mot de passe invalide.";
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
} */
?> -->

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
require_once(__DIR__ . '/google_login_config.php');
include(__DIR__ . '/../../config.php');
require_once '../../vendor/autoload.php';
include_once '../../Controller/UserController.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$pdo = config::getConnexion();
$controller = new UserController();

$email = $password = "";
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
        $sql = "SELECT id, nom, prenom, password, role, verification FROM users WHERE email = :email";

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
                    $verification = $row['verification'];

                    if (password_verify($password, $hashed_password)) {
                        if ($verification == 1) {

                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["nom"] = $nom;
                            $_SESSION["prenom"] = $prenom;
                            $_SESSION["role"] = $role;
                            $_SESSION["verification"] = $verification;

                            $_SESSION['temp_user'] = [
                                'email' => $email,
                                'role' => $role,
                            ];

                            // Generate OTP
                            $otp = rand(100000, 999999);
                            $expires = time() + 180;
                            $expires_at = date('Y-m-d H:i:s', $expires);

                            // Insert OTP into the database
                            /* $stmt = $pdo->prepare("
                                INSERT INTO user_otps (email, otp, expires_at)
                                VALUES (:email, :otp, :expires_at)
                                ON DUPLICATE KEY UPDATE otp = :otp, expires_at = :expires_at
                            ");
                            $stmt->execute([
                                'email' => $email,
                                'otp' => $otp,
                                'expires_at' => $expires_at
                            ]); */
                            if ($controller->storeOpt($email, $otp, $expires_at)) {

                                // Send OTP via email
                                $mail = new PHPMailer(true);
                                $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );
                                try {
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'doghri.zeineb24@gmail.com';
                                    $mail->Password = 'jqdi bkac bizg zktg';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;
                                    $mail->setFrom('doghri.zeineb24@gmail.com', 'Pinnacle');
                                    $mail->addAddress($email);

                                    $mail->isHTML(true);
                                    $mail->Subject = "Your OTP for Login";
                                    $mail->Body = "Your OTP is: $otp";

                                    $mail->send();
                                    echo 'OTP has been sent to your email address.';

                                    header("Location: otp_verification.php");
                                } catch (Exception $e) {
                                    echo "Error: {$mail->ErrorInfo}";
                                }
                            }

                        } else {
                            $login_err = "Inscription non validé.";
                        }
                    } else {
                        $login_err = "Mot de passe invalide.";
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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">
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
            <h1 class="m-0" style="color: #2C24CE ;"><img class="logo" src="Template/img/LOGO 1 blue.png"
                    alt="Pinnacle Logo" style="max-width: 45px;">Pinnacle</h1>
        </div>


        <div class="card p-5 shadow-lg border-0" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Connexion à Pinnacle</h3>
            <?php if (!empty($login_err)): ?>
                <div class="alert alert-danger"><?php echo $login_err; ?></div>
            <?php endif; ?>

            <video id="video" width="640" height="480" autoplay hidden></video>
            <canvas id="canvas" width="640" height="480" hidden></canvas>

            <form id="loginForm" action="login.php" method="POST">

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email">
                    <span class="text-danger"><?php echo $email_err; ?></span>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Entrez votre mot de passe">
                    <span class="text-danger"><?php echo $password_err; ?></span>
                    <p class="mb-0">Mot de passe oublié ? <a href="sent_reset_link.php">Réinitialiser</a></p>
                </div>

                <button id="submit" type="submit" class="btn btn-primary btn-block w-100 rounded-pill">Se
                    connecter</button>
                <button id="face-login-btn" type="button" class="btn btn-secondary btn-block w-100 rounded-pill"
                    onclick="startFaceRecognition()">Connexion Avec Face Id</button>
                <div class="text-center mt-3">
                    <p>ou</p>
                    <p>Se Connecter Avec Google</p>
                    <button type="button" onclick="window.location = '<?php echo $login_url; ?>'"
                        class="btn btn-danger">Login with Google</button>
                </div>
                <div class="text-center mt-3">
                    <p class="mb-0">Vous n'avez pas de compte ? <a href="signup.php">S'inscrire</a></p>
                </div>
            </form>


        </div>

    </div>

    <!-- <script src="js/login.js"></script> -->

    <script>
        function startFaceRecognition() {
            document
                .getElementById("face-login-btn")
                .addEventListener("click", function () {
                    console.log("Facial recognition started");

                    const video = document.getElementById("video");
                    const canvas = document.getElementById("canvas");
                    const context = canvas.getContext("2d");
                    const container = document.getElementsByClassName("video-canvas-container");
                    container.hidden = false;

                    // Start camera stream
                    navigator.mediaDevices
                        .getUserMedia({ video: true })
                        .then(function (stream) {
                            video.srcObject = stream;
                            video.hidden = false; // Show the video element
                            video.play();

                            // Allow video feed to stabilize
                            setTimeout(() => {
                                playVideo();
                            }, 2000);
                        })
                        .catch(function (error) {
                            console.error("Error accessing the camera: ", error);
                            setErrorMessage(
                                "Unable to access the camera. Please check permissions."
                            );
                        });

                    function playVideo() {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                        video.hidden = true; // Hide video after capturing
                        const imageData = canvas.toDataURL("image/png");
                        console.log("image data js: ", imageData);
                        canvas.hidden = true;
                        document.body.style.cursor = "wait";
                        console.log("Sending image to server...");
                        setInfoMessage("Verifying Face ID...");

                        // Send captured image data to the server
                        fetch("login_with_face.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                            },
                            body:`image_data=${encodeURIComponent(imageData)}`,
          })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Server response:", data);
                    if (data.success) {
                        console.log("Face ID detected:", data.face_id); // Log face ID
                        setInfoMessage(data.message);
                        
                        console.log('redirect:',data.redirect);
                        setTimeout(() => { window.location.href = data.redirect }, 2000); // Redirect to profile page
                        document.body.style.cursor = "pointer";
                        stopVideoStream(video);
                    } else {
                        console.error("Error from server:", data.message);
                        setErrorMessage(data.message);
                        stopVideoStream(video);
                    }
                })
                .catch(function (error) {
                    console.error("Error in fetch request:", error);
                    setErrorMessage("An error occurred while processing the request.");
                    stopVideoStream(video);
                });
        }
      });
  }

        function stopVideoStream(video) {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(function (track) {
                    track.stop();
                });
                video.srcObject = null; // Clear the source after stopping
            }
            video.hidden = true; // Hide video element
        }

        function setErrorMessage(message) {
            const form = document.querySelector("form"); // Ensure the form exists
            if (!form) {
                console.error("Form element not found.");
                return;
            }

            // Remove existing messages
            const existingMessages = form.querySelectorAll(".info-message");
            existingMessages.forEach((msg) => msg.remove());

            const messageElement = document.createElement("small");
            messageElement.className = "info-message";
            messageElement.textContent = message;
            messageElement.style.color = "red"; // Customize the color as needed
            messageElement.style.backgroundColor = "#ffd0d0";
            messageElement.style.borderLeftColor = "lightcoral";
            form.prepend(messageElement);
        }
        function setInfoMessage(message) {
            const form = document.querySelector("form"); // Ensure the form exists
            if (!form) {
                console.error("Form element not found.");
                return;
            }

            // Remove existing messages
            const existingMessages = form.querySelectorAll(".info-message");
            existingMessages.forEach((msg) => msg.remove());

            const messageElement = document.createElement("small");
            messageElement.className = "info-message";
            messageElement.textContent = message;
            messageElement.style.color = "green"; // Customize the color as needed
            form.prepend(messageElement);
        }
    </script>

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