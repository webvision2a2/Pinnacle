<?php 
require_once  '../../vendor/autoload.php';
include_once  '../../config_zeineb.php';
include_once  '../../Controller/UserController.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
     <div class="text-center mb-4">
        <h1 class="m-0" style="color: #2C24CE ;"><img class="logo" src="Template/img/LOGO 1 blue.png" alt="Pinnacle Logo" style="max-width: 45px;">Pinnacle</h1>
    </div> 
    <div class="card p-5 shadow-lg border-0" style="max-width: 400px; width: 100%;">
        <form id="forgot-password-form" method="post" autocomplete="off" novalidate="true">
            <h3 class="text-center mb-4">Mot de Passe Oublié?</h3>
            <div class="form-group mb-3">
                <label for="email">Saisissez votre adresse email:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email">
            </div>
            <button id="submit" type="submit" class="btn btn-primary btn-block w-100 rounded-pill">Envoyer le lien de réinitialisation</button>
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database using UserController
    if($controller->isEmailExists($email)) {
        $token = bin2hex(random_bytes(32)); // Generate a secure random token
        $expires = time() + 3600; // Token valid for 1 hour
        $expires_at = date('Y-m-d H:i:s', $expires);

        // Store the token in the database associated with the user
        if ($controller->storePasswordResetToken($email, $token, $expires_at)) {
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
                $mail->SMTPDebug = 10;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'doghri.zeineb24@gmail.com';  // SMTP username
                $mail->Password = 'jqdi bkac bizg zktg';           // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('doghri.zeineb24@gmail.com','Pinnacle');
                $mail->addAddress($email);     // Add a recipient

                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $resetLink = "http://localhost/Projet_web/View/frontOffice_zeineb/reset_password.php?token=".$token;
                $mail->Body    = "
                Please click on the following link to reset your password: <a href='{$resetLink}'>Reset Password</a>
                ";

                $mail->send();
                echo "Check your email for the password reset link.";
            } catch (Exception $e) {
                echo 'Mailer Error: '.$mail->ErrorInfo;
            }
        } else {
            echo 'Failed to store reset token.';
        }
    } else {
        echo 'No account found with that email address.';
    }
}
?>