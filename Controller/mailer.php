<?php
// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  // Make sure PHPMailer is included

$mail = new PHPMailer(true); // Instantiate PHPMailer


try {
    $mail->isSMTP();
$mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'pinnacleofficiel@gmail.com';  // Your Gmail address
$mail->Password = 'eiji wfde spsg nnna';          // App Password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS
$mail->Port = 587;  // TLS port                  // TCP port to connect to (587 for TLS)

    //Recipients
    $mail->setFrom('pinnacleofficiel@gmail.com', 'Pinnacle');
    $mail->addAddress('allagui.dhiaa20@gmail.com');  // Add a recipient email address

    // Content
    $mail->isHTML(true);                                          // Set email format to HTML
    $mail->Subject = 'PHPMailer Test Email';
    $mail->Body    = 'This is a test email sent using <b>PHPMailer</b>';

    // Send the email
    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Message could not be sent.';
    }
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
    
}
?>
