<?php
// dashboard.php

// Include the database connection and CRUD functions
include_once '../../Model/Domaine.php';
include_once '../../Model/Cours.php';
include_once '../../Controller/CRUD.php';
include_once '../../config_zeineb.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add this near the top of the file after the includes
$statsData = getStatistics();
// Handle form submission for creating a new domaine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    if (empty($_POST['nom']) || strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 50) {
        $errorMessage = "Le nom du domaine doit contenir entre 3 et 50 caractères.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "../../view/backoff/Templates/uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);

            // Check if uploads directory exists, if not create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                if (addDomaines($_POST['nom'], $_POST['description'], $_POST['competence'], $targetFile) === false) {
                    $errorMessage = "Un domaine avec ce nom existe déjà.";
                } else {
                    header("Location: dashboard.php");
                    exit;
                }
            } else {
                $errorMessage = "Une erreur est survenue lors du téléchargement de l'image.";
            }
        }
    }
}

// Handle deletion of a domaine
if (isset($_GET['delete'])) {
    deleteDomaines($_GET['delete']);
}

// Handle editing a domaine
$domaineToEdit = null;
if (isset($_GET['edit'])) {
    $domaineToEdit = getDomaineById($_GET['edit']);
}

// Handle form submission for updating a domaine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $competence = $_POST['competence'];
    $image = null;

    if (empty($nom) || strlen($nom) < 3 || strlen($nom) > 50) {
        $errorMessage = "Le nom du domaine doit contenir entre 3 et 50 caractères.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "../../view/backoff/Templates/uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image = $targetFile;
            }
        }

        if (is_null($image)) {
            $currentDomaine = getDomaineById($id);
            $image = $currentDomaine['image'];
        }
    }

}

// Fetch all domaines for display
$domaines = readDomaines();

// Handle form submission for creating a new course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createcours'])) {
    $nomCours = $_POST['nomCours'];
    $domaine_id = $_POST['domaine_id'];

    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../../view/backoff/Templates/uploads/";
        $targetFile = $targetDir . basename($_FILES['fichier']['name']);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $targetFile)) {
            addCours($domaine_id, $nomCours, $targetFile);
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    }
}

// Handle deletion of a course
if (isset($_GET['deletecours'])) {
    deleteCours($_GET['deletecours']);
}

// Handle editing a course
$courseToEdit = null;
if (isset($_GET['editcours'])) {
    $courseToEdit = getCoursById($_GET['editcours']);
}

// Handle form submission for updating a course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatecours'])) {
    $id = $_POST['id'];
    $nomCours = $_POST['nomCours'];
    $domaine_id = $_POST['domaine_id'];
    $filePath = null;

    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../../view/backoff/Templates/uploads/";
        $filePath = $targetDir . basename($_FILES['fichier']['name']);

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $filePath)) {
            // Successfully uploaded new file
        } else {
            echo "Une erreur est survenue lors du téléchargement du fichier.";
        }
    } else {
        // If no new file was uploaded, keep the existing one
        $currentCourse = getCoursById($id);
        $filePath = $currentCourse['fichier']; // Use existing file path if no new upload is made
    }

    // Update the course with the current or new file path
    updateCours($id, $domaine_id, $nomCours, $filePath);

    header("Location: dashboard.php");
    exit;
}

// Fetch all courses for display
$cours = readCours(); // Fetch all courses
// Pagination settings
$itemsPerPage = 4;
$currentDomainePage = isset($_GET['domaine_page']) ? (int) $_GET['domaine_page'] : 1;
$currentCoursPage = isset($_GET['cours_page']) ? (int) $_GET['cours_page'] : 1;

// Fetch data with pagination
$domaines = readDomaines($currentDomainePage, $itemsPerPage);
$cours = readCours($currentCoursPage, $itemsPerPage);

// Calculate total pages
$totalDomaines = getTotalDomaines();
$totalCours = getTotalCours();
$totalDomainePages = ceil($totalDomaines / $itemsPerPage);
$totalCoursPages = ceil($totalCours / $itemsPerPage);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link href="../../Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../../view/backoff/Templates/css/sb-admin-2.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }

        .container-fluid {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .form-heading {
            color: #007bff;
        }

        .btn-success {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="img/LOGO white.png" alt="Logo" style="max-height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">Pinnacle</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="../../view/backoff/dashboard.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Catalogue</span>
        </a>
    </li>
</ul> -->

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon">
                    <img class="logo" src="../frontOffice_zeineb/Template/img/LOGO white.png" alt="Pinnacle Logo"
                        style="max-width: 30px;">
                </div>
                <div class="sidebar-brand-text mx-3" style="font-size: 1.5rem; font-weight: bold;">Pinnacle</div>
            </a>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de Bord</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Utilisateurs -->
            <li class="nav-item">
                <a class="nav-link" href="../backOffice_zeineb/users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>

            <!-- Nav Item - Catalogue -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Catalogue</span>
                </a>
            </li>

            <!-- Nav Item - Entretien -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Enretiens</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="../backOfficeChams/listQuiz.php">Quiz</a>
                        <a class="collapse-item" href="../backOfficeChams/listUserQuiz.php">Utilisateurs</a>
                        <a class="collapse-item" href="../backOfficeChams/listFeedback.php">Feedbacks</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Ateliers -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Psychologie</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../backoffice moemen/topicsList.php">Topics List</a>
                        <a class="collapse-item" href="../backoffice moemen/createTopic.php">Create Topic</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Stages -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Reseaux</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../backofficeahmed/main.php">Stages</a>
                        <a class="collapse-item" href="../backofficeahmed/main2.php">Societes</a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="../BackOffice/tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables des evennements</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../BackOffice/events_participants.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables des participants</span></a>
            </li>




            <!-- Spacer to push items to top -->
            <div class="flex-grow-1">
                </=div>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Se Déconnecter Button -->
                <li class="nav-item">
                    <a class="nav-link" href="../frontOffice_zeineb/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Se Déconnecter</span>
                    </a>
                </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">EYA MARIEM EZZAIER</span>
                                <img class="img-profile rounded-circle" src="img/eyaa.png">
                            </a>
                            <div class='dropdown-menu dropdown-menu-right shadow animated--grow-in'
                                aria-labelledby='userDropdown'>
                                <a class='dropdown-item' href='#'><i
                                        class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i> Profil</a>
                                <a class='dropdown-item' href='#'><i
                                        class='fas fa-cogs fa-sm fa-fw mr-2 text-gray-400'></i> Paramètres</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'><i
                                        class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i> Déconnexion</a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Begin Page Content -->
                <div class='container-fluid'>
                    <h1 class='h3 mb-4 text-gray-800'>Domaines</h1>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <!-- Total Domains Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                                Domaines</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $statsData['totalDomaines']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Courses Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total
                                                Cours</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $statsData['totalCours']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Most Active Domain Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Domaine
                                                le Plus Actif</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                if ($statsData['mostActiveDomain']) {
                                                    echo htmlspecialchars($statsData['mostActiveDomain']['domain_name']);
                                                    echo ' (' . $statsData['mostActiveDomain']['course_count'] . ' cours)';
                                                } else {
                                                    echo 'Aucun';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Domain Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Dernier Domaine Ajouté</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $statsData['latestDomaine'] ? htmlspecialchars($statsData['latestDomaine']['nom']) : 'Aucun'; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Statistics Cards -->
                    <!-- Create or Edit Domain Form -->
                    <form method='POST' enctype='multipart/form-data' onsubmit='return validateForm()' class='mb-4'>
                        <?php if ($domaineToEdit): ?>
                            <h4 class='form-heading'>Modifier le domaine</h4>
                            <input type='hidden' name='id' value='<?php echo htmlspecialchars($domaineToEdit['id']); ?>'>
                        <?php else: ?>
                            <h4 class='form-heading'>Créer un nouveau domaine</h4>
                        <?php endif; ?>
                        <div class='form-group'>
                            <label for='nom'>Nom:</label>
                            <input type='text' name='nom' id='nom' placeholder='Entrez le nom du domaine'
                                class='form-control'
                                value="<?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['nom']) : ''; ?>">
                            <div id='nomError' class='error-message'></div>
                        </div>

                        <div class='form-group'>
                            <label for='description'>Description:</label>
                            <textarea name='description' id='description' placeholder='Entrez la description du domaine'
                                class='form-control'><?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['description']) : ''; ?></textarea>
                            <div id='descriptionError' class='error-message'></div>
                        </div>

                        <div class='form-group'>
                            <label for='competence'>Compétence:</label>
                            <input type='text' name='competence' id='competence'
                                placeholder='Entrez la compétence associée' class='form-control'
                                value="<?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['competence']) : ''; ?>">
                            <div id='competenceError' class='error-message'></div>
                        </div>

                        <div class='form-group'>
                            <label for='image'>Image:</label>
                            <input type='file' name='image' id='image' accept='.jpg,.jpeg,.png,.gif'
                                class='form-control-file'>
                            <div id='imageError' class='error-message'></div>
                        </div>

                        <?php if ($domaineToEdit): ?>
                            <button type='submit' name='update' class='btn btn-warning btn-block'>Mettre à jour</button>
                        <?php else: ?>
                            <button type='submit' name='create' class='btn btn-success btn-block'>Créer</button>
                        <?php endif; ?>
                    </form>

                    <h4>Liste des domaines</h4>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Compétence</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($domaines as $domaine): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($domaine['id']); ?></td>
                                    <td><?php echo htmlspecialchars($domaine['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($domaine['description']); ?></td>
                                    <td><?php echo htmlspecialchars($domaine['competence']); ?></td>
                                    <td><img src="<?php echo htmlspecialchars($domaine['image']); ?>"
                                            alt="<?php echo htmlspecialchars($domaine['nom']); ?>" style='width: 100px;'>
                                    </td>
                                    <td>
                                    <td>
                                        <a href="?edit=<?php echo htmlspecialchars($domaine['id']); ?>"
                                            class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="?delete=<?php echo htmlspecialchars($domaine['id']); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce domaine ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalDomainePages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $currentDomainePage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?domaine_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </table>

                    <!-- Cours Section -->
                    <h1 class='h3 mb-4 text-gray-800'>Cours</h1>

                    <form method='POST' enctype='multipart/form-data' onsubmit="return validateCourseForm();"
                        class='mb-4'>
                        <h4 class='form-heading'>Créer un nouveau cours</h4>

                        <div class='form-group'>
                            <label for='domaine_id'>Domaine:</label>
                            <select name='domaine_id' id='domaine_id' class='form-control'>
                                <option value='' disabled selected>Sélectionnez un domaine</option>
                                <?php foreach ($domaines as $domaine): ?>
                                    <option value='<?php echo htmlspecialchars($domaine['id']); ?>'>
                                        <?php echo htmlspecialchars($domaine['nom']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id='domainError' class='error-message'></div>
                        </div>

                        <div class='form-group'>
                            <label for='nomCours'>Nom du cours:</label>
                            <input type='text' name='nomCours' id='nomCours' placeholder='Entrez le nom du cours'
                                class='form-control'
                                value="<?php echo isset($courseToEdit) ? htmlspecialchars($courseToEdit['nom']) : ''; ?>" />
                            <div id='coursenomError' class='error-message'></div>
                        </div>

                        <div class='form-group'>
                            <label for='fichier'>Fichier:</label>
                            <input type='file' name='fichier' id='fichier' accept='.pdf,.doc,.docx'
                                class='form-control' />
                            <div id='fileError' class='error-message'></div>
                        </div>

                        <?php if ($courseToEdit): ?>
                            <input type="hidden" name="id"
                                value="<?php echo htmlspecialchars($courseToEdit['id_cours']); ?>">
                            <button type='submit' name='updatecours' class='btn btn-warning btn-block'>Mettre à jour le
                                cours</button>
                        <?php else: ?>
                            <button type='submit' name='createcours' class='btn btn-success btn-block'>Créer Cours</button>
                        <?php endif; ?>
                    </form>

                    <h4>Liste des Cours</h4>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Fichier</th>
                                <th>Domaine</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cours as $course): ?>
                                <?php $domaine = getDomaineById($course['domaine_id']); ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['id_cours']); ?></td>
                                    <td><?php echo htmlspecialchars($course['nom']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($course['fichier']); ?>">Télécharger</a></td>
                                    <td><?php echo htmlspecialchars($domaine['nom']); ?></td>
                                    <td>
                                        <a href="?editcours=<?php echo htmlspecialchars($course['id_cours']); ?>"
                                            class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="?deletecours=<?php echo htmlspecialchars($course['id_cours']); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalCoursPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $currentCoursPage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?cours_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </table>
                </div><!-- End of Main Content -->


                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>© 2023 MonSite</span>
                        </div>
                    </div>
                </footer><!-- End of Footer -->

                <script src="../../Templates/vendor/jquery/jquery.min.js"></script>
                <script src="../../Templates/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="../../Templates/js/sb-admin-2.min<script "></script>

                <script>
                    function validateForm() {
                        let isValid = true;

                        // Clear previous error messages
                        document.getElementById('nomError').innerText = '';
                        document.getElementById('descriptionError').innerText = '';
                        document.getElementById('competenceError').innerText = '';
                        document.getElementById('imageError').innerText = '';

                        // Validate Nom
                        const nom = document.getElementById('nom').value.trim();
                        if (nom === '') {
                            document.getElementById('nomError').innerText = 'Le nom est requis.';
                            isValid = false;
                        }

                        // Validate Description
                        const description = document.getElementById('description').value.trim();
                        if (description === '') {
                            document.getElementById('descriptionError').innerText = 'La description est requise.';
                            isValid = false;
                        }

                        // Validate Compétence
                        const competence = document.getElementById('competence').value.trim();
                        if (competence === '') {
                            document.getElementById('competenceError').innerText = 'La compétence est requise.';
                            isValid = false;
                        }

                        return isValid;
                    } function validateCourseForm() {
                        let isValid = true;

                        // Clear previous error messages
                        document.getElementById('domainError').innerText = '';
                        document.getElementById('coursenomError').innerText = '';
                        document.getElementById('fileError').innerText = '';

                        // Validate Domaine
                        const domaineId = document.getElementById('domaine_id').value;
                        if (domaineId === '' || domaineId === null) {
                            document.getElementById('domainError').innerText = 'Veuillez sélectionner un domaine.';
                            isValid = false;
                        }

                        // Validate Nom du Cours
                        const nomCours = document.getElementById('nomCours').value.trim();
                        if (nomCours === '') {
                            document.getElementById('coursenomError').innerText = 'Le nom du cours est requis.';
                            isValid = false;
                        }

                        // Validate Fichier (if updating, ensure a file is provided)
                        const fichier = document.getElementById('fichier').value;
                        if (fichier === '' && !document.querySelector('input[name="id"]')) {
                            document.getElementById('fileError').innerText = 'Le fichier est requis.';
                            isValid = false;
                        }

                        return isValid;
                    }

                </script>

</body>

</html>