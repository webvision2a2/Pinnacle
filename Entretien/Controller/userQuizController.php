<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/user_quiz.php');

class UserQuizController {
    // READ: Fetch all quizzes attempted by a specific user
    public function listUserQuizzes($user_id) {
        $sql = "SELECT * FROM user_quiz WHERE user_id = :user_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // CREATE: Add a new user quiz entry
    public function addUserQuiz($userQuiz) {
        $sql = "INSERT INTO user_quiz (quiz_id, user_id, score, attempts, email) VALUES (:quiz_id, :user_id, :score, :attempts, :email)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'quiz_id' => $userQuiz->quiz_id,
                'user_id' => $userQuiz->user_id,
                'score' => $userQuiz->score,
                'attempts' => $userQuiz->attempts,
                'email' => $userQuiz->email
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // READ: Fetch a single user quiz by ID
    public function showUserQuiz($id) {
        $sql = "SELECT * FROM user_quiz WHERE id = :id";
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
    public function listQuizzes() {
        $sql = "SELECT * FROM user_quiz";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Function to fetch email based on user_id
    function fetchUserEmail($userId) {
        $sql = "SELECT email FROM user_quiz WHERE id = :user_id"; // Adjust table/column names as needed
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['email'] ?? null; // Return email or null if not found
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
    public function deleteUserQuiz($quiz_id) {
        $sql = "DELETE FROM user_quiz WHERE id = :quiz_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':quiz_id', $quiz_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //UPDATE: Update an existing user quiz entry
    public function updateUserQuiz($id, $updatedUserQuiz) {
        $sql = "UPDATE user_quiz SET 
                    quiz_id = :quiz_id,
                    user_id = :user_id,
                    score = :score,
                    attempts = :attempts,
                    email = :email
                WHERE id = :id";
        
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'quiz_id' => $updatedUserQuiz->quiz_id,
                'user_id' => $updatedUserQuiz->user_id,
                'score' => $updatedUserQuiz->score,
                'attempts' => $updatedUserQuiz->attempts,
                'email' => $updatedUserQuiz->email,
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }}
     
}


//USER FFETCHING FUNCTIONS

class UserController {
    // Fetch email based on user ID
    public function fetchEmailByUserId($user_id): ?string {
        $sql = "SELECT email FROM users WHERE id = :user_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['email'] ?? null; // Return email or null if not found
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Fetch name (nom and prenom) based on user ID
    public function fetchNameByUserId($user_id): ?string {
        $sql = "SELECT nom, prenom FROM users WHERE id = :user_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['nom'] . ' ' . $result['prenom']; // Concatenate nom and prenom
            }
            return null; // Return null if not found
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    // Fetch all user IDs from the database
    public function fetchAllUserIds(): array {
        $sql = "SELECT id FROM users";
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql); // Simple query since there are no parameters
            return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch all IDs as an array
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return []; // Return an empty array if there is an error
        }
    }
}

?>
