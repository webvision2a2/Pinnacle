<?php
include '../config.php'; // Configuration file (DB connection)
include '../models/modelevent.php'; // Model for event management

$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    switch ($action) {
        case 'insertion':
            insertion();
            break;
        case 'update':
            update();
            break;
    }
}

function insertion()
{
    // Récupération des données depuis le formulaire
    $options = $_POST['options'] ?? null; 
    $date = $_POST['date'] ?? '';

    // Validation des données
    if ($options === null || (is_array($options) && empty($options))) {
        echo "Erreur : Veuillez sélectionner au moins une option.";
        return;
    }
    if (empty($date)) {
        echo "Erreur : Veuillez sélectionner une date.";
        return;
    }

    // Assurez-vous que $options est un tableau
    if (!is_array($options)) {
        $options = [$options];
    }

    try {
        // Connexion à la base de données
        $pdo = config::getConnexion();

        // Concaténer les options dans une seule chaîne
        $optionsConcatenated = implode(', ', array_map('htmlspecialchars', $options));

        // Préparer la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date) VALUES (:title, :event_date)");

        // Insertion dans la base de données
        $stmt->execute([
            ':title' => $optionsConcatenated,
            ':event_date' => $date,
        ]);

        echo "Succès : L'événement a été enregistré avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion : " . $e->getMessage();
    }
}



?>
