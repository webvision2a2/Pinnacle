<?php
include '../config_zeineb.php';

// Check if the ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Get the database connection
    $db = config::getConnexion();

    // Prepare the SQL query to delete the participant
    $query = "DELETE FROM events_participants WHERE id = :id";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind the ID to the prepared statement
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // If the delete is successful, redirect to the list page
        header('Location: http://localhost/Integration_ProjetWeb/View/BackOffice/events_participants.php'); // Change this to your list page URL
        exit;
    } else {
        // If something went wrong, show an error message
        echo "Error deleting participant.";
    }
} else {
    echo "Invalid participant ID.";
}
?>
