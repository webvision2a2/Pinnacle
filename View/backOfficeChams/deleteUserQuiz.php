<?php
include_once '../../Controller/userQuizController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userQuizController = new UserQuizController();
    $userQuizController->deleteUserQuiz($id);
    header('Location: listUserQuiz.php'); // Redirect back to the quiz list
} else {
    echo "Invalid request.";
}
?>
