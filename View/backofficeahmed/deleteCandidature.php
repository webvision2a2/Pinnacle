<?php
require_once '../../controller/CandidatureController.php';
require_once '../../config.php'; // Inclure votre fichier config pour la connexion à la base de données

// Vérifiez si l'ID de la candidature et l'ID du stage sont passés en paramètre POST
if (isset($_POST['id']) && isset($_POST['id_stage'])) {
    $id = $_POST['id'];
    $id_stage = $_POST['id_stage'];

    // Instancier le contrôleur de candidatures
    $candidatureController = new CandidatureController();
    
    // Supprimer la candidature
    $candidatureController->deleteCandidature($id);

    // Rediriger vers la liste des candidatures après suppression
    header("Location: listCandidatures.php?id_stage=" . htmlspecialchars($id_stage));
    exit();
} else {
    echo "<p>ID de candidature ou ID de stage manquant.</p>";
    exit();
}
?>
