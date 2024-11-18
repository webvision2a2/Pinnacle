<?php
session_start();

include_once ''

function addEvent($title, $id_event, $event_date) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO events (title, id_event, event_date) VALUES (:title, :id_event, :event_date)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':id_event', $id_event);
    $stmt->bindParam(':event_date', $event_date);

    return $stmt->execute();
}

function modifyEvent($id, $title, $id_event, $event_date) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE events SET title = :title, id_event = :id_event, event_date = :event_date WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':id_event', $id_event);
    $stmt->bindParam(':event_date', $event_date);

    return $stmt->execute();
}

function deleteEvent($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

function getAllEvents() {
    global $pdo;
    return $pdo->query("SELECT * FROM events")->fetchAll();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_event'])) {
        addEvent($_POST['title'], $_POST['id_event'], $_POST['event_date']);
        echo "Event added successfully!";
    } elseif (isset($_POST['modify_event'])) {
        modifyEvent($_POST['id'], $_POST['title'], $_POST['id_event'], $_POST['event_date']);
        echo "Event modified successfully!";
    } elseif (isset($_POST['delete_event'])) {
        deleteEvent($_POST['id']);
        echo "Event deleted successfully!";
    }
}

$events = getAllEvents();
?>

