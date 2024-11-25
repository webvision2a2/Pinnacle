<?php
class EventModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEvents() {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY event_date DESC");
        return $stmt->fetchAll();
    }

    public function addEvent($titre, $date) {
        $stmt = $this->pdo->prepare("INSERT INTO events (title, event_date) VALUES (:title, :event_date)");
        $stmt->bindParam(':title', $titre);
        $stmt->bindParam(':event_date', $date);
        $stmt->execute();
    }

    public function updateEvent($id, $titre, $date) {
        $stmt = $this->pdo->prepare("UPDATE events SET title = :title, event_date = :event_date WHERE id_event = :id");
        $stmt->bindParam(':title', $titre);
        $stmt->bindParam(':event_date', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteEvent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id_event = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
