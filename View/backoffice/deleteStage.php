<?php
require_once '../../controller/StageController.php';

// Vérifiez si l'ID du stage est défini
if (isset($_GET["id_stage"])) {
    $id_stage = $_GET["id_stage"];
    echo "ID reçu : " . $id_stage . "<br>"; // Message de débogage
    $stageController = new StageController();

    // Essayez de supprimer le stage
    if ($stageController->deleteStage($id_stage)) {
        echo "Stage supprimé avec succès.<br>"; // Message de débogage
        // Redirection après la suppression
        header('Location: stageList.php');
        exit();
    } else {
        echo "Erreur lors de la suppression du stage.<br>";
    }
} else {
    echo "ID de stage non défini.";
}
?>
