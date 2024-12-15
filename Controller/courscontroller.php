<?php
// Controller/courscontroller.php

include_once '../config/config.php'; // Correct path to config.php

function addCours($nom, $fichier, $domaine_id) {
    $db = config::getConnexion();

    $stmt = $db->prepare("INSERT INTO cours (nom, fichier, domaine_id) VALUES (:nom, :fichier, :domaine_id)");
    
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fichier', $fichier);
    $stmt->bindParam(':domaine_id', $domaine_id);

    return $stmt->execute();
}

function deleteCours($id_cours) {
    $db = config::getConnexion();

    $stmt = $db->prepare("DELETE FROM cours WHERE id_cours = :id_cours");
    
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function readCours() {
    $db = config::getConnexion();

    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $stmt = $db->query("SELECT * FROM cours");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCoursById($id_cours) {
    $db = config::getConnexion();

    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $stmt = $db->prepare("SELECT * FROM cours WHERE id_cours = :id_cours");
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return null; 
    }
}

function updateCours($id_cours, $nom, $fichier = null, $domaine_id) {
    $db = config::getConnexion();

    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    if ($fichier !== null) {
        // Update query with file
        $stmt = $db->prepare("UPDATE cours SET nom = :nom, fichier = :fichier, domaine_id = :domaine_id WHERE id_cours = :id_cours");
        if (!$stmt) throw new Exception("Failed to prepare SQL statement.");
        $stmt->bindParam(':fichier', $fichier);
    } else {
        // Update query without changing file
        $stmt = $db->prepare("UPDATE cours SET nom = :nom, domaine_id = :domaine_id WHERE id_cours = :id_cours");
        if (!$stmt) throw new Exception("Failed to prepare SQL statement.");
    }

    // Bind parameters and execute the statement
    if ($stmt) { 
        // Bind parameters
        $stmt->bindParam(':nom', $nom);
        if ($fichier !== null) {
            // Only bind if there's a file
            $stmt->bindParam(':fichier', $fichier);
        }
        // Bind remaining parameters
        $stmt->bindParam(':domaine_id', $domaine_id);
        $stmt->bindParam(':id_cours', 	$id_cours, PDO::PARAM_INT);
        
        return $stmt->execute(); 
    } else {
        throw new Exception("Failed to prepare SQL statement.");
    }
}
?>