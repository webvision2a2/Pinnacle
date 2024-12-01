<?php 
require_once  '../../vendor/autoload.php';
include_once  '/../../core/config.php';
include_once  '/../../controllers/UserController.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$controller = new UserController();
?>

<body>
    <form id="forgot-password-form" method="post" autocomplete="off" novalidate="true">
        <h1>Forgot Your Password?</h1>
        <label for="email">Enter your email address:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit" class="nav-button">Send Reset Link</button>
    </form>
</body>


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
            try {
                $mail->isSMTP();
                $mail->SMTPDebug = 1;
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'doghri.zeineb24@gmail.com';  // SMTP username
                $mail->Password = 'jqdi bkac bizg zktg';           // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('doghri.zeineb24@gmail.com','Pinnacle');
                $mail->addAddress($email);     // Add a recipient

                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $resetLink = "http://localhost/Projet_web/View/frontOffice/reset_password_applepie.php?token=".$token;//badel lien w THABET FIH!!!!!!!!!!!!!!!!!!!
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
} else {
    echo 'Invalid request.';
}
?>