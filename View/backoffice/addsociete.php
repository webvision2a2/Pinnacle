<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Société</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    require_once '../../controller/SocieteController.php';
    $societeController = new SocieteController();
    $error = "";
    $success = false;

    if (isset($_POST["submit"])) {
        if (empty($_POST["nom_soc"]) || empty($_POST["adresse"]) || empty($_POST["numero"]) || empty($_POST["email"])) {
            $error = "Please fill in all required fields.";
        } elseif (!preg_match('/^[0-9]{8}$/', $_POST["numero"])) {
            $error = "Le numéro doit comporter exactement 8 chiffres.";
        } else {
            // Assurez-vous que $_POST['speciality'] est toujours un tableau
            $specialities = is_array($_POST['speciality']) ? $_POST['speciality'] : [$_POST['speciality']];
            
            // Create a Societe object
            $societe = new Societe(
                null,
                $_POST['nom_soc'],
                $_POST['adresse'],
                $_POST['numero'],
                $_POST['email'],
                $specialities
            );

            // Add the society to the database
            if ($societeController->addSociete($societe)) {
                $success = true;
            } else {
                $error = "An error occurred while adding the society.";
            }
        }
    }
    ?>
    
    <h1 class="text-center">Coordonnées de la société</h1>
    <form align="center" action="" method="POST">
        <div class="mb-3">
            <label for="nom_soc" class="form-label">Nom de la Société :</label>
            <input type="text" class="form-control" id="nom_soc" name="nom_soc">
        </div>
        <h6 id="1" class="text-danger"></h6>
        <h6 id="2" class="text-success"></h6>
        <div class="mb-3">
        <label for="adresse" class="form-label">Adresse Physique de la Société :</label>
        <input type="text" class="form-control" id="adresse" name="adresse">
        </div>
        <h6 id="3" class="text-danger"></h6>
        <h6 id="4" class="text-success"></h6>
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro de Téléphone de la Société :</label>
            <input type="text" class="form-control" id="numero" name="numero">
        </div>
        <h6 id="5" class="text-danger"></h6>
        <h6 id="6" class="text-success"></h6>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email de la Société :</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <h6 id="7" class="text-danger"></h6>
        <h6 id="8" class="text-success"></h6>
        <div class="form-group" id="checkbox">
            <label for="speciality" class="form-label">Les domaines de la Société :</label>
            <table class="table table-borderless">
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="web" name="speciality" value="web">
                            <label class="btn btn-outline-primary w-100" for="web">Développement Web</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="design" name="speciality" value="design">
                            <label class="btn btn-outline-primary w-100" for="design">Design</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="dev_log" name="speciality" value="dev_log">
                            <label class="btn btn-outline-primary w-100" for="dev_log">Développement de Logiciels</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="sec" name="speciality" value="sec">
                            <label class="btn btn-outline-primary w-100" for="sec">Sécurité Informatique</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="reseau" name="speciality" value="reseau">
                            <label class="btn btn-outline-primary w-100" for="reseau">Réseaux et Télécommunications</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="ai" name="speciality" value="ai">
                            <label class="btn btn-outline-primary w-100" for="ai">Intelligence Artificielle (IA)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="data_science" name="speciality" value="data_science">
                            <label class="btn btn-outline-primary w-100" for="data_science">Data Science</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="cloud" name="speciality" value="cloud">
                            <label class="btn btn-outline-primary w-100" for="cloud">Informatique en Nuage (Cloud Computing)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="vr_ar" name="speciality" value="vr_ar">
                            <label class="btn btn-outline-primary w-100" for="vr_ar">Réalité Virtuelle (VR) et Réalité Augmentée (AR)</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="ad_sys" name="speciality" value="ad_sys">
                            <label class="btn btn-outline-primary w-100" for="ad_sys">Administration des Systèmes</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="bigdata" name="speciality" value="bigdata">
                            <label class="btn btn-outline-primary w-100" for="bigdata">Big Data</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="dev_mobile" name="speciality" value="dev_mobile">
                            <label class="btn btn-outline-primary w-100" for="dev_mobile">Développement Mobile</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="robotics" name="speciality" value="robotics">
                            <label class="btn btn-outline-primary w-100" for="robotics">Robotics</label>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                            <input type="checkbox" class="btn-check" id="iot" name="speciality" value="iot">
                            <label class="btn btn-outline-primary w-100" for="iot">Internet des Objets (IoT)</label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <h6 id="9" class="text-danger"></h6>
        <h6 id="10" class="text-success"></h6>
        <button type="submit" class="btn btn-primary" id="button" name="submit">Ajouter</button>

        
    </form>
    <script src="condition.js"></script>
    
</body>

</html>
