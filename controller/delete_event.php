<?php
include '../controller/contolleradmin.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Call the function to delete the event
    DeleteEvent($id);

    // Redirect back to the events list
    header("Location: ../view/BackOffice/tables.php");
    exit();
}

function DeleteEvent($id) {
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
    
}
?>
