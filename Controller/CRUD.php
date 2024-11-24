<?php
include_once 'C:\xampp\htdocs\validation 2\config.php';

function addDomaines($name, $description, $competence, $image) {  
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("INSERT INTO domaines (name, description, competence, image) VALUES (:name, :description, :competence, :image)");
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':competence', $competence);
    $stmt->bindParam(':image', $image);
    
    return $stmt->execute();
}
function deleteDomaines($id) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("DELETE FROM domaines WHERE id = :id");
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function readDomaines() {
    $database = new Database();
    $db = $database->connect();

    if (!$db) {
        return "Database connection failed.";
    }

    return $db->query("SELECT * FROM domaines")->fetchAll(PDO::FETCH_ASSOC);
}

function getDomaineById($id) {
    $database = new Database();
    $db = $database->connect();

    if (!$db) {
        return "Database connection failed.";
    }

    $stmt = $db->prepare("SELECT * FROM domaines WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return null; 
    }
}

function updateDomaines($id, $name, $description, $competence, $image = null) {
    $database = new Database();
    $db = $database->connect();

    if (!$db) {
        return "Database connection failed.";
    }

    if ($image !== null) {
        // Update query with image
        $stmt = $db->prepare("UPDATE domaines SET name = :name, description = :description, competence = :competence, image = :image WHERE id = :id");
        // Bind parameters
        $stmt->bindParam(':image', $image);
    } else {
        // Update query without image
        $stmt = $db->prepare("UPDATE domaines SET name = :name, description = :description, competence = :competence WHERE id = :id");
    }

    // Bind remaining parameters and execute the statement
    if ($stmt) { 
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':competence', $competence);

        // Bind ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute(); 
    } else {
        return "Failed to prepare SQL statement.";
    }

}


function addCours($Domaine_id, $nom, $fichier) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("INSERT INTO cours (Domaine_id, nom, fichier) VALUES (:Domaine_id, :nom, :fichier)");
    $stmt->bindParam(':Domaine_id', $Domaine_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fichier', $fichier);

    return $stmt->execute();
}
function deleteCours($id_cours) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("DELETE FROM cours WHERE id_cours = :id_cours");
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);

    return $stmt->execute();
}
// Remove this function from catalogue.php
function getCoursByDomaineId($domaineId) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("SELECT * FROM cours WHERE Domaine_id = :domaine_id");
    $stmt->bindParam(':domaine_id', $domaineId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}
function readCours() {
    $database = new Database();
    $db = $database->connect();

    return $db->query("SELECT * FROM cours")->fetchAll(PDO::FETCH_ASSOC);
}

function getCoursById($id_cours) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("SELECT * FROM cours WHERE id_cours = :id_cours");
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCours($id_cours, $Domaine_id, $nom, $fichier) {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare("UPDATE cours SET Domaine_id = :Domaine_id, nom = :nom, fichier = :fichier WHERE id_cours = :id_cours");
    $stmt->bindParam(':Domaine_id', $Domaine_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fichier', $fichier);
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);

    return $stmt->execute();
}

// CRUD functions for Domaines...
// (Include the addDomaines, deleteDomaines, readDomaines, getDomaineById, and updateDomaines functions here as shown previously)
?>