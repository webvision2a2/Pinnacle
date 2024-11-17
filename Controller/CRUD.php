<?php
// Models/CRUD.php

include_once  '../../Models/Database.php';

function adddomaines($name, $description, $image) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("INSERT INTO domaines (name, description, image) VALUES (:name, :description, :image)");
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    
    return $stmt->execute();
}

function deletedomaines($id) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("DELETE FROM domaines WHERE id = :id");
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function readdomaines() {
    $database = new Database();
    $db = $database->connect();

    // Check if the connection was successful
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    // Prepare and execute the query using PDO
    $stmt = $db->query("SELECT * FROM domaines");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all domaines as an associative array
}

function getDomaineById($id) {
    $database = new Database();
    $db = $database->connect(); // Establish a connection

    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $stmt = $db->prepare("SELECT * FROM domaines WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the domaine as an associative array
    } else {
        return null; // No domaine found with that ID
    }
}

function updatedomaines($id, $name, $description, $image = null) {
    $database = new Database();
    $db = $database->connect(); // Establish a connection

    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    if ($image) {
        // Update query with image
        $stmt = $db->prepare("UPDATE domaines SET name = :name, description = :description, image = :image WHERE id = :id");
        $stmt->bindParam(':image', $image);
    } else {
        // Update query without image
        $stmt = $db->prepare("UPDATE domaines SET name = :name, description = :description WHERE id = :id");
    }

    // Bind parameters and execute the statement
    if ($stmt) {  // Check if statement was prepared successfully
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute(); // Execute the update and return success status
    } else {
        throw new Exception("Failed to prepare SQL statement.");
    }
    
}