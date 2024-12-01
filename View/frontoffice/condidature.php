<?php
require_once '../../controller/StageController.php';
require_once '../../controller/SocieteController.php';

$stageController = new StageController();
$societeController = new SocieteController();
$error = "";
$success = false;

if (isset($_POST["submit"])) {
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
            // Déplacer le fichier uploadé vers le répertoire souhaité (ex: "uploads/")
            $uploadDir = 'uploads/';
            $cvPath = $uploadDir . basename($cv['name']);
            
            if (move_uploaded_file($cv['tmp_name'], $cvPath)) {
                // Traitez les données du formulaire ici (comme les enregistrer dans la base de données)
                $success = true;
            } else {
                $error = "Erreur lors de l'upload du fichier.";
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
</head>
<body>
    <h1 class="text-center">Formulaire de Candidature pour un Stage</h1>

    <?php if ($success): ?>
        <p class="success-message">Votre candidature a été soumise avec succès!</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error-message"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form align="center" action="" method="POST" id="candidatureForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" class="form-control" id="nom" name="nom" >
            <div id="nom_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" >
            <div id="prenom_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de téléphone :</label>
            <input type="text" class="form-control" id="numero" name="numero" >
            <div id="numero_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email :</label>
            <input type="email" class="form-control" id="email" name="email" >
            <div id="email_message" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="cv" class="form-label">Upload CV (PDF, DOC, DOCX) :</label>
            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" >
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
</body>
</html>
