<?php
session_start();
include(__DIR__ . '/../../config.php');
require_once  '../../vendor/autoload.php';
include_once  '../../Controller/UserController.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$pdo = config::getConnexion();
$controller = new UserController();

if (isset($_SESSION['temp_user']['email'])) {
    $email = $_SESSION['temp_user']['email'];

    // Generate a new OTP
    $newOtp = rand(100000, 999999);
    $expires = time() + 180; 
    $expires_at = date('Y-m-d H:i:s', $expires);

    if ($controller->storeOpt($email, $newOtp, $expires_at)) {

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
            $mail->Body = "Your OTP is: $newOtp";
        
            $mail->send();
            echo 'OTP has been sent to your email address.';

            header("Location: otp_verification.php");
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }
} else {
    $_SESSION['error'] = "Session expirée. Veuillez vous reconnecter.";
}

header("Location: otp_verification.php");
exit;
?>
