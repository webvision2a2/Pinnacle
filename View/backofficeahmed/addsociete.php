<?php
require_once '../../controller/SocieteController.php';
$societeController = new SocieteController();
$error = "";
$success = false;

if (isset($_POST["submit"])) {
    if (empty($_POST["nom_soc"]) || empty($_POST["adresse"]) || empty($_POST["numero"]) || empty($_POST["email"])) {
        $error = "Please fill in all required fields.";
    } else {
        $specialities = isset($_POST['speciality']) && is_array($_POST['speciality']) ? $_POST['speciality'] : [];

        // Create a Societe object
        $societe = new Societe(
            null,  
            $_POST['nom_soc'],
            $_POST['adresse'],
            $_POST['numero'],
            $_POST['email'],
            $specialities  
        );

        // Ajouter la société à la base de données
        $result = $societeController->addSociete($societe);
        
        // Debug: Afficher le résultat du contrôleur
        error_log("Résultat de l'ajout de la société : " . $result);
        
        if ($result === 'success') {
            $success = true;
        } elseif ($result === 'duplicate') {
            $error = "A society with this name already exists.";
        } else {
            $error = "An error occurred while adding the society.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Société</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1 class="text-center">Coordonnées de la société</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success">Société ajoutée avec succès!</div>
    <?php endif; ?>
    <form align="center" action="" method="POST" id="societeForm">
        <div class="mb-3">
            <label for="nom_soc" class="form-label">Nom de la Société :</label>
            <input type="text" class="form-control" id="nom_soc" name="nom_soc">
            <div id="nom_soc_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse Physique de la Société :</label>
            <input type="text" class="form-control" id="adresse" name="adresse">
            <div id="adresse_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de Téléphone de la Société :</label>
            <input type="text" class="form-control" id="numero" name="numero">
            <div id="numero_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email de la Société :</label>
            <input type="text" class="form-control" id="email" name="email">
            <div id="email_message" class="invalid-feedback"></div>
        </div>
        <div class="form-group" id="select">
            <label for="speciality" class="form-label">Le domaine de la Société :</label>
            <div class="form-floating">
                <select class="form-select" id="speciality" name="speciality[]" multiple aria-label="Floating label select example">
                    <option value="web">Développement Web</option>
                    <option value="design">Design</option>
                    <option value="dev_log">Développement de Logiciels</option>
                    <option value="sec">Sécurité Informatique</option>
                    <option value="reseau">Réseaux et Télécommunications</option>
                    <option value="ai">Intelligence Artificielle (IA)</option>
                    <option value="data_science">Data Science</option>
                    <option value="cloud">Informatique en Nuage (Cloud Computing)</option>
                    <option value="vr_ar">Réalité Virtuelle (VR) et Réalité Augmentée (AR)</option>
                    <option value="ad_sys">Administration des Systèmes</option>
                    <option value="bigdata">Big Data</option>
                    <option value="dev_mobile">Développement Mobile</option>
                    <option value="robotics">Robotics</option>
                    <option value="iot">Internet des Objets (IoT)</option>
                </select>
                <div id="speciality_message" class="invalid-feedback"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" id="submitButton">Ajouter</button>
    </form>
    <script src="condition2.js"></script>
</body>
</html>
