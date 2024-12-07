<?php
require_once '../../controller/StageController.php';

$stageController = new StageController();
$error = "";
$success = false;

if (isset($_POST["submit"])) {
    if (empty($_POST["nom_stage"]) || empty($_POST["type"]) || empty($_POST["duration"]) || empty($_POST["email"]) || empty($_POST["id_societe"])) {
        $error = "Veuillez remplir tous les champs requis.";
    } else {
        // Récupérer les spécialités
        $specialities = isset($_POST['speciality']) && is_array($_POST['speciality']) ? $_POST['speciality'] : [];

        // Créer un objet Stage
        $stage = new Stage(
            null,
            $_POST['nom_stage'], // Ajout du nom du stage
            $_POST['type'],
            $_POST['duration'],
            $_POST['email'],
            $specialities,
            $_POST['documents'],
            $_POST['id_societe'] // Utilisez l'ID de la société sélectionnée
        );

        // Ajouter le stage à la base de données
        if ($stageController->addStage($stage)) {
            $success = true;
        } else {
            $error = "Une erreur s'est produite lors de l'ajout du stage.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Stage</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1 class="text-center">Coordonnées du Stage</h1>
    <form align="center" action="" method="POST" id="stageForm">
        <div class="mb-3">
            <label for="nom_stage" class="form-label">Nom du stage :</label>
            <input type="text" class="form-control" id="nom_stage" name="nom_stage" >
            <div id="nom_stage_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="id_societe" class="form-label">Sélectionner une société :</label>
            <select id="id_societe" name="id_societe" class="form-control" >
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
                        echo "<option value='{$societe['id']}'>{$societe['nom_soc']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type de stage :</label>
            <select id="type" class="form-control" name="type">
                <option value="pfe">Stage de fin d'études (PFE)</option>
                <option value="initiation">Stage d'initiation</option>
                <option value="perfectionnement">Stage de perfectionnement</option>
                <option value="autre">Autre (veuillez préciser ci-dessous)</option>
            </select>
            <input type="text" class="form-control mt-2" id="type_other" name="type_other" placeholder="Précisez si 'Autre'">
            <div id="type_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="speciality" class="form-label">Spécialités :</label>
            <select id="speciality" class="form-control" name="speciality[]" multiple>
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
        <div class="mb-3">
            <label for="duration" class="form-label">Durée du stage :</label>
            <input type="text" class="form-control" id="duration" name="duration" >
            <div id="duration_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email :</label>
            <input type="email" class="form-control" id="email" name="email" >
            <div id="email_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="documents" class="form-label">Documents requis :</label>
            <input type="text" class="form-control" id="documents" name="documents" >
            <div id="documents_message" class="invalid-feedback"></div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit" id="submitButton">Ajouter</button>
    </form>

    <script>
    document.getElementById("stageForm").addEventListener("submit", function(event) {
        let isValid = true;

        // Récupération des éléments DOM
        const nomStage = document.getElementById("nom_stage");
        const type = document.getElementById("type");
        const typeOther = document.getElementById("type_other");
        const speciality = document.getElementById("speciality");
        const duration = document.getElementById("duration");
        const email = document.getElementById("email");
        const documents = document.getElementById("documents");

        // Validation du nom du stage
        if (nomStage.value.length === 0) {
            document.getElementById("nom_stage_message").innerHTML = "Veuillez indiquer le nom du stage.";
            nomStage.classList.add("is-invalid");
            isValid = false;
        } else {
            nomStage.classList.remove("is-invalid");
            nomStage.classList.add("is-valid");
            document.getElementById("nom_stage_message").innerHTML = "Correct";
        }

        // Validation du type de stage
        if (type.value === "autre" && typeOther.value.length < 2) {
            document.getElementById("type_message").innerHTML = "Veuillez préciser le type de stage.";
            typeOther.classList.add("is-invalid");
            isValid = false;
        } else {
            typeOther.classList.remove("is-invalid");
            typeOther.classList.add("is-valid");
            document.getElementById("type_message").innerHTML = "Correct";
        }

        // Validation des spécialités
        if (speciality.selectedOptions.length === 0) {
            document.getElementById("speciality_message").innerHTML = "Il faut choisir au moins une spécialité.";
            speciality.classList.add("is-invalid");
            isValid = false;
        } else {
            speciality.classList.remove("is-invalid");
            speciality.classList.add("is-valid");
            document.getElementById("speciality_message").innerHTML = "Correct";
        }

        // Validation de la durée du stage
        if (duration.value.length === 0) {
            document.getElementById("duration_message").innerHTML = "Veuillez indiquer la durée du stage.";
            duration.classList.add("is-invalid");
            isValid = false;
        } else {
            duration.classList.remove("is-invalid");
            duration.classList.add("is-valid");
            document.getElementById("duration_message").innerHTML = "Correct";
        }

        // Validation de l'email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value)) {
            document.getElementById("email_message").innerHTML = "L'email doit être dans un format valide.";
            email.classList.add("is-invalid");
            isValid = false;
        } else {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            document.getElementById("email_message").innerHTML = "Correct";
        }

        // Validation des documents requis
        if (documents.value.length === 0) {
            document.getElementById("documents_message").innerHTML = "Veuillez indiquer les documents requis.";
            documents.classList.add("is-invalid");
            isValid = false;
        } else {
            documents.classList.remove("is-invalid");
            documents.classList.add("is-valid");
            document.getElementById("documents_message").innerHTML = "Correct";
        }

        // Si une validation échoue, empêcher la soumission du formulaire
        if (!isValid) {
            event.preventDefault();
        }
    });
    </script>
</body>
</html>
            