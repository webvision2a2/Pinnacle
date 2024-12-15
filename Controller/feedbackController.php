<?php
include_once(__DIR__ . '/../config_zeineb.php');
include(__DIR__ . '/../Model/feedback.php');

//composer FILES 

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;




class FeedbackController {
    // READ: Fetch all feedback for a specific quiz
    public function listFeedback($quiz_id) {
        $sql = "SELECT * FROM feedback WHERE quiz_id = :quiz_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':quiz_id', $quiz_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // CREATE: Add a new feedback entry
    public function addFeedback($feedback) {
        $sql = "INSERT INTO feedback (quiz_id, user_id, score, feedback_text, recommendations) VALUES (:quiz_id, :user_id, :score, :feedback_text, :recommendations)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'quiz_id' => $feedback->quiz_id,
                'user_id' => $feedback->user_id,
                'score' => $feedback->score,
                'feedback_text' => $feedback->feedback_text,
                'recommendations' => json_encode($feedback->recommendations)
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // DELETE: Remove feedback by ID
    public function deleteFeedback($id) {
        $sql = "DELETE FROM feedback WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // UPDATE: Update feedback details by ID
    public function updateFeedback($id, $feedback) {
        $sql = "UPDATE feedback SET 
                quiz_id = :quiz_id, 
                user_id = :user_id, 
                score = :score, 
                feedback_text = :feedback_text, 
                recommendations = :recommendations
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'quiz_id' => $feedback->getQuizId(),
                'user_id' => $feedback->getUserId(),
                'score' => $feedback->getScore(),
                'feedback_text' => $feedback->getFeedbackText(),
                'recommendations' => json_encode($feedback->getRecommendations())
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // READ: Fetch a single feedback by ID
    public function showFeedback($id) {
        $sql = "SELECT * FROM feedback WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

     // READ: Fetch all quizzes
    public function listFeedbacks() {
        $sql = "SELECT * FROM feedback";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //MAILER COMPOSER FUNCTION

    public function sendFeedbackEmail($recipientEmail, $recipientName, $quizId, $score, $feedbackText, $recommendations) {
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        try {
            // Debug settings
            $mail->SMTPDebug = 2; // Set to 2 for detailed debug output
            $mail->Debugoutput = 'error_log'; // Log debug output to PHP error log

            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chams.nmiri@gmail.com'; // Your email address
            $mail->Password   = 'hloa zysa lubu sezy'; // Your email password or App Password
            $mail->SMTPSecure = /* PHPMailer::ENCRYPTION_SMTPS */PHPMailer::ENCRYPTION_STARTTLS;;
            $mail->Port       = /* 465 */587;

            // Recipients
            $mail->setFrom('chams.nmiri@gmail.com', 'Pinnacle_project');
            $mail->addAddress($recipientEmail, $recipientName); // Add recipient

            // Email content in French
            $mail->isHTML(true);
            $mail->SMTPOptions = array(
                                        'ssl' => array(
                                            'verify_peer' => false,
                                            'verify_peer_name' => false,
                                            'allow_self_signed' => true
                                        )
                                    );
            $mail->Subject = "Votre Feedback pour le Quiz ID: $quizId";
            $mail->Body    = "
                <h1>Feedback sur votre Quiz</h1>
                <p>Bonjour $recipientName,</p>
                <p>Merci d'avoir participé au Quiz ID: $quizId.</p>
                <p>Votre score : <strong>$score</strong></p>
                <p>Voici votre feedback :</p>
                <p><em>$feedbackText</em></p>
                <p>Nous vous recommandons également les ressources suivantes pour vous améliorer :</p>
                <ul>";

            foreach ($recommendations as $recommendation) {
                $mail->Body .= "<li>$recommendation</li>";
            }

            $mail->Body .= "</ul>
                <p>Continuez à apprendre et à vous améliorer !</p>
                <p>Cordialement,</p>
                <p><strong>Pinnacle Project Team</strong></p>";

            // Send the email
            $mail->send();
            echo 'L\'email de feedback a été envoyé.';
        } catch (Exception $e) {
            echo "L'email n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
        }
    }





}
?>
