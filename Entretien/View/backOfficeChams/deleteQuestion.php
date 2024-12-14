<?php
include_once '../../Controller/questionController.php';

$id_quiz = $_GET['id_quiz'];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quizController = new QuestionController();
    $quizController->deleteQuestion($_GET['id']);
    header("Location: listQuestion.php?id_quiz=$id_quiz"); 
    exit;
} else {
    echo "Erreur: Question ID is missing.";
}
?>