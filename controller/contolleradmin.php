<?php
// Utilisation de chemins absolus pour inclure les fichiers
include __DIR__ . '/../config.php';
include __DIR__ . '/../models/modelevent.php';


function GetAllevents()
{
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->query("SELECT * FROM events");
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Remove the following lines:
        // echo "<pre>";
        // print_r($events);
        // echo "</pre>";
        
        return $events;
    } catch (Exception $e) {
        error_log("Error fetching events: " . $e->getMessage());
        return [];
    }
}
function GetEventById($id) {
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
function AddEvent($id_client, $title, $date) {
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("INSERT INTO events (id_client, title, event_date) VALUES (?, ?, ?)");
        $stmt->execute([$id_client, $title, $date]);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
function UpdateEvent($id, $id_client, $title, $date) {
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("UPDATE events SET id_client = ?, title = ?, event_date = ? WHERE id = ?");
        $stmt->execute([$id_client, $title, $date, $id]);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} 
?>

