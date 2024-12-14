<?php
include_once(__DIR__ . '/../config.php');
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

        try {

            $mail->SMTPDebug = 2; // Set to 2 for detailed debug output
            $mail->Debugoutput = 'error_log'; // Log debug output to PHP error log
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chams.nmiri@gmail.com'; // Your email address
            $mail->Password   = 'hloa zysa lubu sezy'; // Your email password or App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('chams.nmiri@gmail.com', 'Pinnacle_project');
            $mail->addAddress($recipientEmail, $recipientName); // Add recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Your Feedback for Quiz ID: $quizId";
            $mail->Body    = "
                <h1>Quiz Feedback</h1>
                <p>Dear $recipientName,</p>
                <p>Thank you for taking Quiz ID: $quizId.</p>
                <p>Your score: <strong>$score</strong></p>
                <p>Feedback: $feedbackText</p>
                <p>Recommendations:</p>
                <ul>";

            foreach ($recommendations as $recommendation) {
                $mail->Body .= "<li>$recommendation</li>";
            }

            $mail->Body .= "</ul>";

            // Send the email-----
            $mail->send();
            echo 'Feedback email has been sent.';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }





}
?>
