<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor_dhia/autoload.php'; // Include Composer autoload

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function testSendQRToEmail($userEmail) {
    // Event details (dummy for testing)
    $event = [
        'title' => 'Test Event',
        'date' => '2024-12-15'
    ];
    $ticket_code = strtoupper(uniqid('TICKET_')); // Generate a unique ticket code
    $qrData = "Event: {$event['title']}\nDate: {$event['date']}\nTicket Code: {$ticket_code}";

    // Generate the QR code
    $options = new QROptions([
        'outputType' => QRCode::OUTPUT_IMAGE_PNG, // PNG format
        'eccLevel'   => QRCode::ECC_L,
        'scale'      => 5,
    ]);
    
    $qrcode = new QRCode($options);

    // Define path to save the QR code
    $qrCodePath = sys_get_temp_dir() . '/qrcode.png';

    // Render and save the QR code to a file
    $qrcode->render($qrData, $qrCodePath);

    // Send the email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pinnacleofficiel@gmail.com'; // Replace with your email
        $mail->Password = 'eiji wfde spsg nnna';         // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pinnacleofficiel@gmail.com', 'Pinnacle');
        $mail->addAddress($userEmail); // Recipient's email address

        // Embed QR Code in the email
        $mail->addEmbeddedImage($qrCodePath, 'qr_code_cid');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email with QR Code';
        $mail->Body = "
            <h1>QR Code Test</h1>
            <p>Hello,</p>
            <p>Here is your test QR code for the event <b>{$event['title']}</b>.</p>
            <p>Event Date: <b>{$event['date']}</b></p>
            <p>Ticket Code: <b>$ticket_code</b></p>
            <p><img src='cid:qr_code_cid' alt='QR Code'></p>
        ";

        if ($mail->send()) {
            echo "Email sent successfully!";
        } else {
            echo "Failed to send email.";
        }

        // Delete the temporary QR code file after sending the email
        if (file_exists($qrCodePath)) {
            unlink($qrCodePath);
        }
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}

// Call the function with your test email
testSendQRToEmail('allagui.dhiaa20@gmail.com');
?>
