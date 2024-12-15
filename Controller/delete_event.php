<?php
include 'contolleradmin.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Call the function to delete the event
    if (DeleteEvent($id)) {
        // Redirect back to the events list
        header("Location: ../View/BackOffice/tables.php");
        exit();
    } else {
        echo "Error deleting event.";
    }
}

function DeleteEvent($id)
{
    try {
        // Ensure the ID is a valid integer to prevent SQL injection
        if (!is_numeric($id)) {
            throw new Exception("Invalid event ID.");
        }

        // Get database connection
        $pdo = config::getConnexion();

        // Prepare the DELETE query
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");

        // Execute the query with the ID parameter
        $stmt->execute([$id]);

        // Check if any rows were affected (event deleted)
        if ($stmt->rowCount() > 0) {
            return true;  // Event was deleted
        } else {
            // If no rows were affected, return false (event not found or already deleted)
            return false;
        }
    } catch (Exception $e) {
        // Display error message in case of any issues
        die("Error: " . $e->getMessage());
    }
}
