<?php
require_once '../../controller/StageController.php';
<<<<<<< HEAD
require_once '../../controller/SocieteController.php';

// Instancier le contrôleur de stages pour récupérer les données
$stageController = new StageController();

// Récupérer les termes de recherche et la pagination
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 6; // Nombre de stages par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Liste des stages avec pagination et recherche
$list = $stageController->searchAndPaginate($searchTerm, $limit, $offset);
$totalResults = $stageController->countSearchResults($searchTerm);
$totalPages = ceil($totalResults / $limit);

=======
<<<<<<< HEAD
require_once '../../controller/SocieteController.php';
=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091

// Instancier le contrôleur de stages pour récupérer les données
$stageController = new StageController();
$list = $stageController->listStage(); // Liste des stages récupérée

<<<<<<< HEAD
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
// Instancier le contrôleur de sociétés pour récupérer les données
$societeController = new SocieteController();
$societes = $societeController->listSocietes(); // Liste des sociétés récupérée

// Transformer la liste des sociétés en tableau associatif pour un accès rapide par ID
$societeNames = [];
foreach ($societes as $societe) {
    $societeNames[$societe['id']] = $societe['nom_soc'];
}
<<<<<<< HEAD
=======
=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Liste des Stages</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Liste des Stages</h1>
                    </div>

<<<<<<< HEAD
                    <!-- Formulaire de recherche -->
                    <form method="GET" action="" class="form-inline mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Rechercher" value="<?= htmlspecialchars($searchTerm); ?>" aria-label="Rechercher" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

=======
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
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
<<<<<<< HEAD
                                                        <th>Nom du stage</th>
=======
<<<<<<< HEAD
                                                        <th>Nom du stage</th>
=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                        <th>Société</th>
                                                        <th>Type</th>
                                                        <th>Durée</th>
                                                        <th>Email</th>
                                                        <th>Spécialité</th>
                                                        <th>Documents</th>
<<<<<<< HEAD
                                                        <th>Candidatures</th>
=======
<<<<<<< HEAD
                                                        <th>Candidatures</th>
=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Parcours des stages récupérés pour les afficher
                                                    foreach ($list as $stage) {
                                                        // Vérifiez que speciality est un tableau avant d'utiliser implode()
                                                        $specialities = is_array($stage['speciality']) ? implode(", ", $stage['speciality']) : $stage['speciality'];
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                        
                                                        // Récupérer les candidatures pour ce stage
                                                        $candidatures = $stageController->getCandidaturesForStage($stage['id_stage']);
                                                        $candidatureCount = count($candidatures); // Compter le nombre de candidatures

                                                        // Récupérer le nom de la société
                                                        $societeName = isset($societeNames[$stage['id_societe']]) ? $societeNames[$stage['id_societe']] : 'Inconnue';
                                                    ?>
                                                    <tr>
                                                        <td><?= $stage['id_stage']; ?></td>
                                                        <td><?= htmlspecialchars($stage['nom_stage']); ?></td>
                                                        <td><?= htmlspecialchars($societeName); ?></td>
                                                        <td><?= htmlspecialchars($stage['type']); ?></td>
                                                        <td><?= htmlspecialchars($stage['duration']); ?></td>
                                                        <td><?= htmlspecialchars($stage['email']); ?></td>
                                                        <td><?= htmlspecialchars($specialities); ?></td>
                                                        <td><?= htmlspecialchars($stage['documents']); ?></td>
                                                        <td>
                                                            <!-- Afficher le nombre de candidatures -->
                                                            <a href="listCandidatures.php?id_stage=<?= htmlspecialchars($stage['id_stage']); ?>" class="btn btn-info">
                                                                <?= $candidatureCount ?> Candidature(s)
                                                            </a>
                                                        </td>
<<<<<<< HEAD
=======
=======
                                                    ?>
                                                    <tr>
                                                        <td><?= $stage['id_stage']; ?></td>
                                                        <td><?= $stage['id_societe']; ?></td>
                                                        <td><?= $stage['type']; ?></td>
                                                        <td><?= $stage['duration']; ?></td>
                                                        <td><?= $stage['email']; ?></td>
                                                        <td><?= $specialities; ?></td>
                                                        <td><?= $stage['documents']; ?></td>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                        <td>
                                                            <!-- Formulaire pour mettre à jour un stage -->
                                                            <form method="POST" action="updateStage.php">
                                                                <input class="btn btn-primary" type="submit" name="update" value="Modifier">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                                <input type="hidden" value="<?= htmlspecialchars($stage['id_stage']); ?>" name="id_stage">
                                                            </form>
                                                            <!-- Lien pour supprimer un stage -->
                                                            <a href="deleteStage.php?id_stage=<?= htmlspecialchars($stage['id_stage']); ?>" class="btn btn-danger">Supprimer</a>
<<<<<<< HEAD
=======
=======
                                                                <input type="hidden" value="<?= $stage['id_stage']; ?>" name="id_stage">
                                                            </form>
                                                            <!-- Lien pour supprimer un stage -->
                                                            <a href="deleteStage.php?id_stage=<?= $stage['id_stage']; ?>" class="btn btn-danger">Supprimer</a>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
<<<<<<< HEAD

                                            <!-- Liens de pagination -->
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                    <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?= $i; ?>&search=<?= htmlspecialchars($searchTerm); ?>"><?= $i; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </nav>

=======
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
                                            <!-- Lien pour ajouter un stage -->
                                            <a class="btn btn-primary" href="main.php" role="button">Ajouter un Stage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD

                </div>
                <!-- End of Main Content -->
=======
                </div>

>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
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
