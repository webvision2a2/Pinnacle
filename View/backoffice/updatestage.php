<?php
require_once '../../controller/StageController.php';
$stageController = new StageController();

if (isset($_POST["update"])) {
    $stage = $stageController->showStage($_POST["id_stage"]);
    if (!$stage) {
        echo "Stage introuvable.";
        exit();
    }
} elseif (isset($_POST["submit"])) {
    $id_stage = $_POST["id_stage"];
    $specialities = isset($_POST['speciality']) ? implode(",", $_POST['speciality']) : '';
    $stage = new Stage(
        $id_stage,
        $_POST['nom_stage'], // Ajout du nom du stage
        $_POST['type'],
        $_POST['duration'],
        $_POST['email'],
        $specialities,
        $_POST['documents'],
        $_POST['id_societe'] // Utilisez l'ID de la société sélectionnée
    );

    if ($stageController->updateStage($stage, $id_stage)) {
        header("Location: main.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du stage.";
    }
} else {
    echo "Accès invalide.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour un Stage</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1 class="text-center">Mettre à jour un Stage</h1>
    <form align="center" action="" method="POST" id="stageForm">
        <input type="hidden" name="id_stage" value="<?= htmlspecialchars($stage['id_stage']); ?>">
        
        <div class="mb-3">
            <label for="nom_stage" class="form-label">Nom du stage :</label>
            <input type="text" class="form-control" id="nom_stage" name="nom_stage" value="<?= htmlspecialchars($stage['nom_stage']); ?>" required>
            <div id="nom_stage_message" class="invalid-feedback"></div>
        </div>
        
        <div class="mb-3">
            <label for="id_societe" class="form-label">Sélectionner une société :</label>
            <select id="id_societe" name="id_societe" class="form-control" required>
                <?php
                // Récupérer toutes les sociétés depuis la base de données
                require_once '../../controller/SocieteController.php';
                $societeController = new SocieteController();
                $societes = $societeController->listSociete();

                // Afficher les sociétés dans la liste déroulante
                if (empty($societes)) {
                    echo "<option>Aucune société disponible</option>";
                } else {
                    foreach ($societes as $societe) {
                        echo "<option value='{$societe['id']}'" . ($societe['id'] == $stage['id_societe'] ? ' selected' : '') . ">{$societe['nom_soc']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="type" class="form-label">Type de stage :</label>
            <select id="type" class="form-control" name="type">
                <option value="pfe" <?= $stage['type'] == 'pfe' ? 'selected' : ''; ?>>Stage de fin d'études (PFE)</option>
                <option value="initiation" <?= $stage['type'] == 'initiation' ? 'selected' : ''; ?>>Stage d'initiation</option>
                <option value="perfectionnement" <?= $stage['type'] == 'perfectionnement' ? 'selected' : ''; ?>>Stage de perfectionnement</option>
                <option value="autre" <?= $stage['type'] == 'autre' ? 'selected' : ''; ?>>Autre (veuillez préciser ci-dessous)</option>
            </select>
            <input type="text" class="form-control mt-2" id="type_other" name="type_other" placeholder="Précisez si 'Autre'" value="<?= $stage['type'] == 'autre' ? $stage['type_other'] : ''; ?>">
            <div id="type_message" class="invalid-feedback"></div>
        </div>
        
        <div class="mb-3">
            <label for="speciality" class="form-label">Spécialités :</label>
            <select id="speciality" class="form-control" name="speciality[]" multiple>
                <option value="web" <?= in_array('web', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Développement Web</option>
                <option value="design" <?= in_array('design', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Design</option>
                <option value="dev_log" <?= in_array('dev_log', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Développement de Logiciels</option>
                <option value="sec" <?= in_array('sec', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Sécurité Informatique</option>
                <option value="reseau" <?= in_array('reseau', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Réseaux et Télécommunications</option>
                <option value="ai" <?= in_array('ai', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Intelligence Artificielle (IA)</option>
                <option value="data_science" <?= in_array('data_science', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Data Science</option>
                <option value="cloud" <?= in_array('cloud', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Informatique en Nuage (Cloud Computing)</option>
                <option value="vr_ar" <?= in_array('vr_ar', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Réalité Virtuelle (VR) et Réalité Augmentée (AR)</option>
                <option value="ad_sys" <?= in_array('ad_sys', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Administration des Systèmes</option>
                <option value="bigdata" <?= in_array('bigdata', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Big Data</option>
                <option value="dev_mobile" <?= in_array('dev_mobile', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Développement Mobile</option>
                <option value="robotics" <?= in_array('robotics', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Robotics</option>
                <option value="iot" <?= in_array('iot', explode(',', $stage['speciality'])) ? 'selected' : ''; ?>>Internet des Objets (IoT)</option>
            </select>
            <div id="speciality_message" class="invalid-feedback"></div>
        </div>
        
        <div class="mb-3">
            <label for="duration" class="form-label">Durée du stage :</label>
            <input type="text" class="form-control" id="duration" name="duration" value="<?= htmlspecialchars($stage['duration']); ?>">
            <div id="duration_message" class="invalid-feedback"></div>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email :</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($stage['email']); ?>">
            <div id="email_message" class="invalid-feedback"></div>
        </div>
        
        <div class="mb-3">
            <label for="documents" class="form-label">Documents requis :</label>
            <input type="text" class="form-control" id="documents" name="documents" value="<?= htmlspecialchars($stage['documents']); ?>">
            <div id="documents_message" class="invalid-feedback"></div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit" id="submitButton">Mettre à jour</button>
    </form>
    <script src="condition3.js"></script>
</body>
</html>
