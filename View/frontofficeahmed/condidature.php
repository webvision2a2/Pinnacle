<?php
require_once '../../Controller/CandidatureController.php';
require_once '../../Controller/StageController.php';

$candidatureController = new CandidatureController();
$stageController = new StageController();
$error = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv'])) {
    if (isset($_POST['submit'])) {

        if (empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["numero"]) || empty($_POST["email"]) || empty($_FILES["cv"]["name"])) {
            $error = "Veuillez remplir tous les champs requis.";
        } else {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $numero = $_POST['numero'];
            $email = $_POST['email'];
            $cv = $_FILES['cv'];

            // Vérifier l'extension du fichier CV
            $allowedExtensions = ['pdf', 'doc', 'docx'];
            $cvExtension = pathinfo($cv['name'], PATHINFO_EXTENSION);

            if (!in_array($cvExtension, $allowedExtensions)) {
                $error = "Le CV doit être au format PDF, DOC ou DOCX.";
            } else {
                // Déplacer le fichier uploadé vers le répertoire souhaité
                $uploadDir = 'C:/xampp/htdocs/projet web/View/frontoffice/cv/';

                // Assurer que le répertoire d'upload existe
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Générer un nom unique pour le fichier afin d'éviter les conflits
                $cvName = uniqid() . '.' . $cvExtension;
                $cvPath = $uploadDir . $cvName; // Chemin complet du fichier à sauvegarder

                if (move_uploaded_file($cv['tmp_name'], $cvPath)) {
                    // Le fichier a été téléchargé avec succès
                    $cvUrl = '/projet%20web/View/frontoffice/cv/' . urlencode($cvName);


                    // Ajouter la candidature à la base de données
                    $candidature = new Candidature(
                        null,
                        $nom,
                        $prenom,
                        $numero,
                        $email,
                        $cvUrl,
                        $_POST['id_stage'],
                        'en cours'
                    );

                    if ($candidatureController->addCandidature($candidature)) {
                        $success = true;
                    } else {
                        $error = "Erreur lors de l'ajout de la candidature.";
                    }
                } else {
                    $error = "Erreur lors de l'upload du fichier.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Candidature pour un Stage</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center mt-4">Formulaire de Candidature pour un Stage</h1>

    <?php if ($success): ?>
        <div class="alert alert-success mt-3" role="alert">
            Votre candidature a été soumise avec succès! <br>
            <a href="<?= htmlspecialchars($cvUrl); ?>" target="_blank">Voir votre CV</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form align="center" action="" method="POST" id="candidatureForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
            <div id="nom_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
            <div id="prenom_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de téléphone :</label>
            <input type="text" class="form-control" id="numero" name="numero" required>
            <div id="numero_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email :</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div id="email_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="cv" class="form-label">Upload CV (PDF, DOC, DOCX) :</label>
            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
            <div id="cv_message" class="invalid-feedback"></div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit" id="submitButton">Soumettre Candidature</button>
    </form>

    <script>
    document.getElementById("candidatureForm").addEventListener("submit", function(event) {
        let isValid = true;

        // Récupération des éléments DOM
        const nom = document.getElementById("nom");
        const prenom = document.getElementById("prenom");
        const numero = document.getElementById("numero");
        const email = document.getElementById("email");
        const cv = document.getElementById("cv");

        // Validation du nom
        if (nom.value.length === 0) {
            document.getElementById("nom_message").innerHTML = "Veuillez indiquer votre nom.";
            nom.classList.add("is-invalid");
            isValid = false;
        } else {
            nom.classList.remove("is-invalid");
            nom.classList.add("is-valid");
            document.getElementById("nom_message").innerHTML = "Correct";
        }

        // Validation du prénom
        if (prenom.value.length === 0) {
            document.getElementById("prenom_message").innerHTML = "Veuillez indiquer votre prénom.";
            prenom.classList.add("is-invalid");
            isValid = false;
        } else {
            prenom.classList.remove("is-invalid");
            prenom.classList.add("is-valid");
            document.getElementById("prenom_message").innerHTML = "Correct";
        }

        // Validation du numéro de téléphone
        if (numero.value.length === 0) {
            document.getElementById("numero_message").innerHTML = "Veuillez indiquer votre numéro de téléphone.";
            numero.classList.add("is-invalid");
            isValid = false;
        } else {
            numero.classList.remove("is-invalid");
            numero.classList.add("is-valid");
            document.getElementById("numero_message").innerHTML = "Correct";
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

        // Validation du fichier CV
        const allowedExtensions = ['pdf', 'doc', 'docx'];
        const cvExtension = cv.value.split('.').pop().toLowerCase();
        if (cv.value.length === 0 || !allowedExtensions.includes(cvExtension)) {
            document.getElementById("cv_message").innerHTML = "Le CV doit être au format PDF, DOC ou DOCX.";
            cv.classList.add("is-invalid");
            isValid = false;
        } else {
            cv.classList.remove("is-invalid");
            cv.classList.add("is-valid");
            document.getElementById("cv_message").innerHTML = "Correct";
        }

        // Si une validation échoue, empêcher la soumission du formulaire
        if (!isValid) {
            event.preventDefault();
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
