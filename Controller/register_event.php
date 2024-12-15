<?php
session_start();

// register_event.php

// Ensure the correct inclusion of necessary libraries and namespaces
include '../config_zeineb.php';
require '../vendor_dhia/autoload.php'; // Include PHPMailer and QR Code library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Get the database connection
$db = config::getConnexion();
try {
    // Get the event_id from the request
    $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

    if ($event_id > 0) {
        try {
            // Check if the event exists
            $eventQuery = "SELECT * FROM events WHERE id = :event_id";
            $eventStmt = $db->prepare($eventQuery);
            $eventStmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $eventStmt->execute();
            $event = $eventStmt->fetch(PDO::FETCH_ASSOC);

            if (!$event) {
                error_log("Event not found for event_id: $event_id");
                header('Location:?error=event_not_found');
                exit;
            }

            // Fetch participants for the event
            $participantQuery = "SELECT nom, prenom, email FROM events_participants WHERE event_id = :event_id";
            $participantStmt = $db->prepare($participantQuery);
            $participantStmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $participantStmt->execute();
            $participants = $participantStmt->fetchAll(PDO::FETCH_ASSOC);

            // Process participants and send emails
            foreach ($participants as $participant) {
                // Insert participant into the events_participants table including event date and user_id
                $insertQuery = "INSERT INTO events_participants (event_id, nom, prenom, email, event_date, user_id) 
                                VALUES (:event_id, :nom, :prenom, :email, :event_date, :user_id)";
                $insertStmt = $db->prepare($insertQuery);
                $insertStmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
                $insertStmt->bindParam(':nom', $participant['nom'], PDO::PARAM_STR);
                $insertStmt->bindParam(':prenom', $participant['prenom'], PDO::PARAM_STR);
                $insertStmt->bindParam(':email', $participant['email'], PDO::PARAM_STR);
                $insertStmt->bindParam(':event_date', $event['date'], PDO::PARAM_STR);  // Add event date here
                $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  // Add user_id here
                $insertStmt->execute();
            
                // Send confirmation email
                $userName = $participant['prenom'] . ' ' . $participant['nom'];
                $emailSent = sendConfirmationEmail($participant['email'], $userName, $event);
            
                if (!$emailSent) {
                    error_log("Failed to send email to {$participant['email']}");
                }
            }
            
            // Redirect after processing
            header('Location: ../view/FrontOffice/eventdispo.php');
            exit;
            

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            header('Location:?error=server_error');
            exit;
        }
    }
} catch (Exception $e) {
    // Handle other general exceptions (logic, mail errors, etc.)
    error_log("General Error: " . $e->getMessage());
    // User-friendly message for general errors
    header('Location:?error=general_error');
    exit;
}

function sendConfirmationEmail($userEmail, $userName, $event) {
    $mail = new PHPMailer(true);

    try {
        // Debugging: Enable verbose SMTP debugging
        $mail->SMTPDebug = 2;  // Enable debug output
        $mail->Debugoutput = 'html'; // Show output in HTML format
        $mail->SMTPOptions = array(
            'ssl' => array(
                     'verify_peer' => false,
                     'verify_peer_name' => false,
                     'allow_self_signed' => true
                 )
             );  
        // Generate the QR code
        $ticket_code = strtoupper(uniqid('TICKET_')); // Unique ticket code
        $qrData = "Event: {$event['title']}\nDate: {$event['date']}\nTicket Code: {$ticket_code}";

        $options = null;

        //$qrcode = new QRCode($options);
        $qrCodePath = 'qrcode.png'; // Save the QR code
        //$qrcode->render($qrData, $qrCodePath);

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
       // $mail->addEmbeddedImage($qrCodePath, 'qr_code_cid');

        // Embed Event Image
        $eventImagePath = '../view/FrontOffice/img/pinnaclemail.png';
        //$mail->addEmbeddedImage($eventImagePath, 'event_image_cid');

        // Prepare event details with defaults for missing inputs
        $eventTitle = $event['title'] ?? 'No Title Available';
        $eventDate = $event['date'] ?? 'No Date Available';
        $eventLocation = $event['location'] ?? 'No Location Available';
        $eventDescription = $event['description'] ?? 'No Description Available';
        $eventCategories = $event['categories'] ?? 'No Categories Available';
        $eventParticipants = $event['participants'] ?? 'No Participants Available';

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Event Registration Confirmation';
        $mail->Body = "
        <html>
        <body>
            <img src='cid:event_image_cid' alt='Event Image' style='max-width: 1000px;'>
            <h1>Thank You for Registering!</h1>
            <p>Hi $userName,</p>
            <p>You have successfully registered for the event: <b>$eventTitle</b>.</p>
            <p>Event Details:</p>
            <ul>
                <li><b>Date:</b> $eventDate</li>
                <li><b>Location:</b> $eventLocation</li>
                <li><b>Ticket Code:</b> $ticket_code</li>
                <li><b>Description:</b> $eventDescription</li>
                <li><b>Categories:</b> $eventCategories</li>
                <li><b>Participants:</b> $eventParticipants</li>
            </ul>
            <p>Your QR Code:</p>
            <img src='cid:qr_code_cid' alt='QR Code'>
            <p>We look forward to seeing you there!</p>
            <p>Best Regards,<br>Pinnacle Events Team</p>
        </body>
        </html>";

        // Send email
        if (!$mail->send()) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
        } else {
            error_log("Message sent successfully to $userEmail");
        }

        return $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: {$e->getMessage()}");
        return false;
    }
}