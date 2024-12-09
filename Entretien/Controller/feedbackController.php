<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/feedback.php');

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
}
?>
