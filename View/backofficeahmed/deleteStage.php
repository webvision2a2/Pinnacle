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
<<<<<<< HEAD
        header('Location: main.php');
=======
<<<<<<< HEAD:View/backofficeahmed/deleteStage.php
        header('Location: main.php');
=======
<<<<<<< HEAD
        header('Location: main.php');
=======
<<<<<<< HEAD
        header('Location: main.php');
=======
<<<<<<< HEAD
        header('Location: main.php');
=======
        header('Location: stageList.php');
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7:View/backoffice/deleteStage.php
>>>>>>> 3a91d57dee08a2e567788638ae118b4e4071076b
        exit();
    } else {
        echo "Erreur lors de la suppression du stage.<br>";
    }
} else {
    echo "ID de stage non défini.";
}
?>
