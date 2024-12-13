<?php

require_once '../../controller/CandidatureController.php';
require_once '../../config.php'; // Inclure votre fichier config pour la connexion à la base de données
require_once '../../vendor/autoload.php'; // Inclure l'autoloader de Composer

// Vérifiez si l'ID de la candidature et l'état sont passés en paramètre POST
if (isset($_POST['id']) && (isset($_POST['accepter']) || isset($_POST['refuser']))) {
    $id = $_POST['id'];
    $etat = isset($_POST['accepter']) ? 'acceptée' : 'refusée';

    // Instancier le contrôleur de candidatures
    $candidatureController = new CandidatureController();

    // Mettre à jour l'état de la candidature
    $candidatureController->updateEtat($id, $etat);

    // Récupérer l'email du candidat
    $candidature = $candidatureController->getCandidatureById($id);
    $email = $candidature['email'];

    // Envoyer l'email de confirmation
    try {
        $candidatureController->envoyerEmail($email, $etat);
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : " . $e->getMessage();
    }

    // Rediriger vers la liste des candidatures après mise à jour
    $id_stage = $_POST['id_stage'];
    header("Location: listCandidatures.php?id_stage=" . htmlspecialchars($id_stage));
    exit();
} else {
    echo "<p>ID de candidature ou état manquant.</p>";
    exit();
} 
?>
