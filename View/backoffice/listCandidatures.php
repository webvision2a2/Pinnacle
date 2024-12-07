<?php
require_once '../../controller/CandidatureController.php';
require_once '../../controller/StageController.php';

$candidatureController = new CandidatureController();
$stageController = new StageController();

if (isset($_GET['id_stage'])) {
    $id_stage = $_GET['id_stage'];
    $candidatures = $candidatureController->listCandidaturesForStage($id_stage);
    $stage = $stageController->showStage($id_stage);
} else {
    echo "<p>ID de stage manquant.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Liste des Candidatures</title>

    <!-- Fonts et CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Navigation -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Liste des Candidatures pour le Stage: <?= htmlspecialchars($stage['nom_stage']); ?></h1>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Numéro</th>
                                                        <th>Email</th>
                                                        <th>CV</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($candidatures as $candidature) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $candidature['id']; ?></td>
                                                        <td><?= htmlspecialchars($candidature['nom']); ?></td>
                                                        <td><?= htmlspecialchars($candidature['prenom']); ?></td>
                                                        <td><?= htmlspecialchars($candidature['numero']); ?></td>
                                                        <td><?= htmlspecialchars($candidature['email']); ?></td>
                                                        <td><a href="<?= htmlspecialchars($candidature['cv']); ?>" target="_blank">Voir le CV</a></td>
                                                        <td>
                                                            <!-- Formulaire pour supprimer une candidature -->
                                                            <form method="POST" action="deleteCandidature.php">
                                                                <input type="hidden" name="id" value="<?= htmlspecialchars($candidature['id']); ?>">
                                                                <input type="hidden" name="id_stage" value="<?= htmlspecialchars($id_stage); ?>">
                                                                <input class="btn btn-danger" type="submit" name="delete" value="Supprimer">
                                                            </form>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <a class="btn btn-primary" href="main.php" role="button">Retour à la liste des stages</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts Bootstrap et JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
