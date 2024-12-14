<?php
include_once '../../Controller/reponseController.php';

$error = ''; // Variable to store errors

// Get parameters from the URL
$id_question = $_GET['id_question'] ?? null;
$quiz_id = $_GET['quiz_id'] ?? null;
$id_reponse = $_GET['id'] ?? null; // The response ID to delete
$question_type = $_GET['question_type'] ?? null;

// Validate input parameters
if (!$id_question || !$quiz_id || !$id_reponse) {
    echo "Invalid request: Missing quiz ID, question ID, or response ID.";
    exit;
}

// Process the deletion
$reponseController = new ReponseController();

try {
    // Call the deleteResponse method to delete the response
    $reponseController->deleteReponse($id_reponse);

    // Redirect to the list of responses page with the relevant IDs
    header("Location: listReponse.php?quiz_id=$quiz_id&id_question=$id_question&question_type=$question_type");
    exit;
} catch (Exception $e) {
    // Handle exceptions and display error
    $error = "Erreur: " . $e->getMessage();
    echo $error;
    exit;
}
?>
