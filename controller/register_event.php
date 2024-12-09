<?php

// register_event.php

// Ensure the correct inclusion of necessary libraries and namespaces
include '../config.php';
require '../vendor/autoload.php'; // Include PHPMailer and QR Code library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Get the database connection
$db = config::getConnexion();

// Get the event_id from the request
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

if ($event_id > 0) {
    try {
        // Fetch participant details from the events_participants table
        $participantQuery = "SELECT nom, prenom, email FROM events_participants WHERE event_id = :event_id";
        $participantStmt = $db->prepare($participantQuery);
        $participantStmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $participantStmt->execute();
        $participants = $participantStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($participants) {
            // Fetch the event details
            $eventQuery = "SELECT * FROM events WHERE id = :event_id";
            $eventStmt = $db->prepare($eventQuery);
            $eventStmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $eventStmt->execute();
            $event = $eventStmt->fetch(PDO::FETCH_ASSOC);

            if ($event) {
                // Send confirmation emails to all participants
                foreach ($participants as $participant) {
                    $emailSent = sendConfirmationEmail(
                        $participant['email'],
                        $participant['prenom'] . ' ' . $participant['nom'],
                        $event
                    );

                    if (!$emailSent) {
                        error_log("Failed to send email to {$participant['email']}");
                    }
                }

                // Redirect to success page
                header('Location: ../view/FrontOffice/eventdispo.php');
                exit;
            } else {
                header('Location: ../view/FrontOffice/register_event.php?error=event_not_found');
                exit;
            }
        } else {
            header('Location: ../view/FrontOffice/register_event.php?error=no_participants');
            exit;
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        header('Location: ../view/FrontOffice/register_event.php?error=server_error');
        exit;
    }
}

function sendConfirmationEmail($userEmail, $userName, $event) {
    $mail = new PHPMailer(true);

    try {
        // Generate the QR code
        $ticket_code = strtoupper(uniqid('TICKET_')); // Unique ticket code
        $qrData = "Event: {$event['title']}\nDate: {$event['date']}\nTicket Code: {$ticket_code}";

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
        ]);

        $qrcode = new QRCode($options);
        $qrCodePath = 'qrcode.png'; // Save the QR code
        $qrcode->render($qrData, $qrCodePath);

        // Configure the email
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pinnacleofficiel@gmail.com';
        $mail->Password = 'eiji wfde spsg nnna'; // Use your actual app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pinnacleofficiel@gmail.com', 'Pinnacle');
        $mail->addAddress($userEmail);

        // Embed QR Code
        $mail->addEmbeddedImage($qrCodePath, 'qr_code_cid');

        // Embed Event Image
        $eventImagePath = '../view/FrontOffice/img/LOGO 1 blue.png';
        $mail->addEmbeddedImage($eventImagePath, 'event_image_cid');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Event Registration Confirmation';
        $mail->Body = "
        <html>
        <body>
            <img src='cid:event_image_cid' alt='Event Image' style='max-width: 300px;'>
            <h1>Thank You for Registering!</h1>
            <p>Hi $userName,</p>
            <p>You have successfully registered for the event: <b>{$event['title']}</b>.</p>
            <p>Event Details:</p>
            <ul>
                <li><b>Date:</b> {$event['date']}</li>
                <li><b>Ticket Code:</b> $ticket_code</li>
                <li><b>Description:</b> {$event['description']}</li>
                <li><b>Categories:</b> {$event['categories']}</li>
                <li><b>Participants:</b> {$event['participants']}</li>
            </ul>
            <p>Your QR Code:</p>
            <img src='cid:qr_code_cid' alt='QR Code'>
            <p>We look forward to seeing you there!</p>
            <p>Best Regards,<br>Pinnacle Events Team</p>
        </body>
        </html>";

        // Send email
        return $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}
