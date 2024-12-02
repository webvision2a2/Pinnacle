<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/reponse.php');

class ReponseController {

    // READ: Fetch all responses for a specific question
    public function listReponses($id_question) {
        $sql = "SELECT * FROM reponse WHERE id_question = :id_question";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_question', $id_question, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // CREATE: Add a new response
    public function addReponse($reponse) {
        $sql = "INSERT INTO reponse 
                VALUES (NULL, :content, :is_correct, :id_question)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'content' => $reponse->getContent(),
                'is_correct' => $reponse->getIsCorrect(),
                'id_question' => $reponse->getIdQuestion()
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // DELETE: Remove a response by ID
    public function deleteReponse($id) {
        $sql = "DELETE FROM reponse WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // UPDATE: Update response details by ID
    public function updateReponse($id, $reponse) {
        $sql = "UPDATE reponse SET 
                content = :content, 
                is_correct = :is_correct, 
                id_question = :id_question 
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'content' => $reponse->getContent(),
                'is_correct' => $reponse->getIsCorrect(),
                'id_question' => $reponse->getIdQuestion()
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // READ: Fetch a single response by ID
    public function showReponse($id) {
        $sql = "SELECT * FROM reponse WHERE id = :id";
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
}
?>
