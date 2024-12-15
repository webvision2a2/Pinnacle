<?php
// add_event.php

// Include database connection
include '../config_zeineb.php';
$db = config::getConnexion();

// Get the form data
$title = $_POST['title'];
$description = $_POST['description'];
$location = $_POST['location'];

$date = $_POST['date'];

// Prepare the SQL query to insert the new event
$query = "INSERT INTO events (title, description, location,  date) 
          VALUES (:title, :description, :location,  :date)";
$stmt = $db->prepare($query);

// Bind the parameters to the query
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':location', $location, PDO::PARAM_STR);

$stmt->bindParam(':date', $date, PDO::PARAM_STR);

// Execute the query
if ($stmt->execute()) {
    echo "Event added successfully!";
} else {
    echo "Error: Could not add event.";
}
?>
