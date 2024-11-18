<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/quiz.php');

class QuizController {

 // READ: Fetch all quizzes
    public function listQuizzes() {
        $sql = "SELECT * FROM quiz";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

// CREATE: Add a new quiz
    public function addQuiz($quiz) {
        $sql = "INSERT INTO quiz
                VALUES (NULL,:title, :description, :author, :creation_date)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'author' => $quiz->getAuthor(),
                'creation_date' => date("Y-m-d") // Auto-generate creation_date (the current date)
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

// DELETE: Remove a quiz by ID
    public function deleteQuiz($id) {
        $sql = "DELETE FROM quiz WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

// UPDATE: Update quiz details by ID
    public function updateQuiz($id, $quiz) {
        $sql = "UPDATE quiz SET 
                title = :title, 
                description = :description, 
                author = :author, 
                creation_date = :creation_date 
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'creation_date' => $quiz->getDatec()->format('y-m-d'),
                'author' => $quiz->getAuthor()
            ]);
        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }



// NOT USED:
// READ: Fetch a single quiz by ID
    public function showQuiz($id) {
        $sql = "SELECT * FROM quiz WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

// Display a quiz (HTML table format)
    public function showQuizDetails($quiz) {
        echo "
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Creation Date</th>
                </tr>
                <tr>
                    <td>{$quiz->getId()}</td>
                    <td>{$quiz->getTitle()}</td>
                    <td>{$quiz->getDescription()}</td>
                    <td>{$quiz->getAuthor()}</td>
                    <td>{$quiz->getCreationDate()}</td>
                </tr>
            </table>
        ";
    }
}
?>
