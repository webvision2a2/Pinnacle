<?php
// Include PHPMailer files (make sure to use the correct path if you're using Composer autoload)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../config_zeineb.php';
require '../vendor/autoload.php'; // Include PHPMailer and QR Code library

// Check if the form data is POSTed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $subject = $_POST['email_subject'];
    $content = $_POST['email_content'];
    $template = $_POST['email_template'];
    $eventId = $_POST['event_id']; // Make sure the event_id is passed in the form

    // Get the user's email from the events_participants table based on the event_id
    if ($eventId > 0) {
        $db = config::getConnexion();
        $query = "SELECT email FROM events_participants WHERE event_id = :event_id LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        $participant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($participant) {
            $userEmail = $participant['email'];  // Retrieve the email address from the database
        } else {
            echo json_encode(['success' => false, 'message' => 'No participants found for this event.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid event ID.']);
        exit;
    }

    // Customize email content based on the template value
    if ($template == 'update') {
        $content .= "\n\nThis is an event update.";
    } elseif ($template == 'reminder') {
        $content .= "\n\nThis is a reminder about your event.";
    } elseif ($template == 'thankyou') {
        $content .= "\n\nThank you for registering for our event.";
    }

    // Send the email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
        $mail->Username   = 'pinnacleofficiel@gmail.com';  
        $mail->Password   = 'eiji wfde spsg nnna';                   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;                                     

        // Recipients
        $mail->setFrom('pinnacleofficiel@gmail.com', 'Pinnacle');
        $mail->addAddress($userEmail);  // Recipient's email address

        // Content
        $mail->isHTML(true);                                          // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = nl2br($content);                             // Set the email content (converts newlines to <br> tags)

        // Send the email
        if ($mail->send()) {
            header('Location:../View/BackOffice/events_participants.php');
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Email could not be sent.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
