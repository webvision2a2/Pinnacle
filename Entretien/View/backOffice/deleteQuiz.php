<?php
include_once '../../Controller/quizController.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quizController = new QuizController();
    $quizController->deleteQuiz($_GET['id']);
    header('Location: listQuiz.php'); // Redirect back to the quiz list
    exit;
} else {
    echo "Error: Quiz ID is missing.";
}
?>