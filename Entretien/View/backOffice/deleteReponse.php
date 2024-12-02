<?php
include_once '../../Controller/reponseController.php'; // Make sure to include the controller for responses

// Get the question ID from the URL (not the quiz ID)
$id_question = $_GET['id_question']; 

// Check if `id` for the response is passed and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Instantiate the ReponseController
    $reponseController = new ReponseController();
    
    // Call the deleteResponse method to delete the response
    $reponseController->deleteReponse($_GET['id']);
    
    // Redirect to the list of responses page, passing the question ID
    header("Location: listReponse.php?id_question=$id_question");
    exit;
} else {
    // If no response ID is passed, display an error message
    echo "Erreur: Response ID is missing.";
}
?>
