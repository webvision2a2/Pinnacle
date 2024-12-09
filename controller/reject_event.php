<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("UPDATE events SET status = 'Rejected' WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ../view/BackOffice/tables.php");
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("No event ID provided.");
}
?>
