<?php
session_start();

$dsn = 'web.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, null, null, $options);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

function getAllEvents() {
    global $pdo;
    return $pdo->query("SELECT * FROM events")->fetchAll();
}

function registerClient($client_id, $event_id, $event_date, $event_name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO registrations (client_id, event_id, event_date, event_name) VALUES (:client_id, :event_id, :event_date, :event_name)");
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->bindParam(':event_name', $event_name);

    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register_event'])) {
        $client_id = $_POST['client_id']; /
        $event_id = $_POST['event_id'];
        
        $stmt = $pdo->prepare("SELECT title, event_date FROM events WHERE id = :id");
        $stmt->bindParam(':id', $event_id);
        $stmt->execute();
        $event = $stmt->fetch();
        
        if ($event) {
            registerClient($client_id, $event_id, $event['event_date'], $event['title']);
            echo "Registration successful for event: " . htmlspecialchars($event['title']);
        } else {
            echo "Event not found.";
        }
    }
}

$events = getAllEvents(); 
?>
