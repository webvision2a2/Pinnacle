<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/question.php');

class QuestionController {

    // READ: Fetch all questions for a specific quiz
    public function listQuestions($id_quiz) {
        $sql = "SELECT * FROM question WHERE id_quiz = :id_quiz"; 
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_quiz', $id_quiz, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // CREATE: Add a new question
    public function addQuestion($question) {
        $sql = "INSERT INTO question 
                VALUES (NULL, :content, :points, :type, :id_quiz)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'content' => $question->getContent(),
                'points' => $question->getPoints(),
                'type' => $question->getType(),
                'id_quiz' => $question->getIdQuiz()
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // DELETE: Remove a question by ID
    public function deleteQuestion($id) {
        $sql = "DELETE FROM question WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // UPDATE: Update question details by ID
    public function updateQuestion($id, $question) {
        $sql = "UPDATE question SET 
                content = :content, 
                points = :points, 
                type = :type, 
                id_quiz = :id_quiz
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'content' => $question->getContent(),
                'points' => $question->getPoints(),
                'type' => $question->getType(),
                'id_quiz' => $question->getIdQuiz()
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    // READ: Fetch a single question by ID
    public function showQuestion($id) {
        $sql = "SELECT * FROM question WHERE id = :id";
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
    
    // READ: Count the number of questions for a specific quiz
    public function countQuestions($id_quiz) {
        $sql = "SELECT COUNT(*) FROM question WHERE id_quiz = :id_quiz";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_quiz', $id_quiz);
            $stmt->execute();

            // Return the count of questions
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    // READ: Fetch the ID and Type for all questions of a specific quiz
    public function getQuestionTypes($id_quiz) {
        $sql = "SELECT id, type FROM question WHERE id_quiz = :id_quiz";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_quiz', $id_quiz, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns an array of questions with id and type
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


// NOT USED:
    // Display question details using the Question class's `show` method
    public function showQuestionDetails($question) {
        $question->show();
    }
}
?>