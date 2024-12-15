<?php
include_once(__DIR__ . '/../config_zeineb.php');
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
                VALUES (NULL,:title, :description, :author, :creation_date, :time_limit, :difficulty, :category, :total_questions)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'author' => $quiz->getAuthor(),
                'creation_date' => date("Y-m-d"), // Auto-generate creation_date (the current date)
                'time_limit' => $quiz->getTimeLimit(),
                'difficulty' => $quiz->getDifficulty(),
                'category' => $quiz->getCategory(),
                'total_questions' => $quiz->getTotalQuestions()

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
                creation_date = :creation_date,
                time_limit = :time_limit, 
                difficulty = :difficulty, 
                category = :category, 
                total_questions = :total_questions 
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'creation_date' => $quiz->getDatec()->format('y-m-d'),
                'author' => $quiz->getAuthor(),
                'time_limit' => $quiz->getTimeLimit(),
                'difficulty' => $quiz->getDifficulty(),
                'category' => $quiz->getCategory(),
                'total_questions' => $quiz->getTotalQuestions()
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


    public function listQuizzesPaginated($limit, $offset) {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT * FROM quiz LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countQuizzes() {
        $db = config::getConnexion();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM quiz");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function listQuizzesByCategoryPaginated($category, $limit, $offset) {
        $db = config::getConnexion();
        if ($category) {
            $stmt = $db->prepare("SELECT * FROM quiz WHERE category = :category LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        } else {
            $stmt = $db->prepare("SELECT * FROM quiz LIMIT :limit OFFSET :offset");
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countQuizzesByCategory($category) {
        $db = config::getConnexion();
        if ($category) {
            $stmt = $db->prepare("SELECT COUNT(*) AS total FROM quiz WHERE category = :category");
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        } else {
            $stmt = $db->query("SELECT COUNT(*) AS total FROM quiz");
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    
    public function listCategories() {
        $db = config::getConnexion();
        $stmt = $db->query("SELECT DISTINCT category AS name FROM quiz");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <th>Time Limit (minutes)</th>
                    <th>Difficulty</th>
                    <th>Category</th>
                    <th>Total Questions</th>
                </tr>
                <tr>
                    <td>{$quiz->getId()}</td>
                    <td>{$quiz->getTitle()}</td>
                    <td>{$quiz->getDescription()}</td>
                    <td>{$quiz->getAuthor()}</td>
                    <td>{$quiz->getCreationDate()}</td>
                    <td>{$quiz->getTimeLimit()}</td>
                    <td>{$quiz->getDifficulty()}</td>
                    <td>{$quiz->getCategory()}</td>
                    <td>{$quiz->getTotalQuestions()}</td>
                </tr>
            </table>
        ";
    }


    public function fetchCategoryByQuizId($quizId) {
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare("SELECT category FROM quiz WHERE id = :quizId");
            $stmt->bindValue(':quizId', $quizId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['category'] : null; // Return category or null if not found
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null; // Return null on error
        }
    }

    
}
?>
