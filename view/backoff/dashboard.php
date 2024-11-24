<?php
// dashboard.php

// Include the database connection and CRUD functions
include_once '../../Models/Domaine.php';
include_once '../../Controller/CRUD.php';
include_once 'C:\xampp\htdocs\validation 2\config.php';

 // Enable error reporting for debugging error_reporting(E_ALL); ini_set('display_errors', 1); // Handle form submission for creating a new domaine if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) { if (empty($_POST['name']) || strlen($_POST['name']) < 3 || strlen($_POST['name']) > 50) { $errorMessage = "Le nom du domaine doit contenir entre 3 et 50 caractères."; } else { if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) { $targetDir = "../../view/backoff/Templates/uploads/"; $targetFile = $targetDir . basename($_FILES["image"]["name"]); if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) { addDomaines($_POST['name'], $_POST['description'], $targetFile, $_POST['competence']); header("Location: dashboard.php"); exit; } else { $errorMessage = "Une erreur est survenue lors du téléchargement de l'image."; } } } }


// Handle deletion of a domaine
if (isset($_GET['delete'])) {
    deleteDomaines($_GET['delete']);
}

// Handle editing a domaine
$domaineToEdit = null; // Initialize variable to hold domaine data for editing

if (isset($_GET['edit'])) {
    $domaineToEdit = getDomaineById($_GET['edit']); // Fetch domaine by ID for editing
}

// Handle form submission for updating a domaine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $competence = $_POST['competence']; // Get competence from POST data
    
    // Initialize variable for the image path
    $image = null;

    // Check if a new image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../../view/backoff/Templates/uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);

        // Check if uploads directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Create directory with appropriate permissions
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile; // Set the image path to the uploaded file path
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }

    // If no new image was uploaded, keep the existing one
    if (is_null($image)) {
        // Fetch the current domaine to retain the existing image
        $currentDomaine = getDomaineById($id);
        $image = $currentDomaine['image']; // Use existing image path if no new upload is made
    }

    // Update the domaine with or without the new image path and include competence
    updatedomaines($id, $name, $description, $competence, $image);
    
    header("Location: dashboard.php"); // Redirect after successful update
    exit;
}

// Fetch all domaines for display
$domaines = readDomaines();

// Handle form submission for creating a new course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createcours'])) {
    $nomCours = $_POST['nomCours'];
    $fichier = $_FILES['fichier']['name'];
    $Domaine_id = $_POST['Domaine_id'];

    $targetDir = "../../view/backoff/Templates/uploads/";
    move_uploaded_file($_FILES["fichier"]["tmp_name"], $targetDir . $fichier);
    
    addCours($Domaine_id, $nomCours, $targetDir . $fichier);
    header("Location: dashboard.php");
    exit;
}

// Handle deletion of a course
if (isset($_GET['deletecours'])) {
    deleteCours($_GET['deletecours']);
}

// Handle editing a course
$courseToEdit = null; // Initialize variable to hold course data for editing
if (isset($_GET['editcours'])) {
    $courseToEdit = getCoursById($_GET['editcours']); // Fetch course by ID for editing
}
// Handle form submission for updating a course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatecours'])) {
    try {
        $id = $_POST['id'];
        $nomCours = $_POST['nomCours'];
        $Domaine_id = $_POST['Domaine_id'];
        
        // Initialize variable for the file path
        $filePath = null;

        // Check if a new file was uploaded
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "../../view/backoff/Templates/uploads/";
            $fileName = basename($_FILES["fichier"]["name"]);
            $filePath = $targetDir . $fileName;

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $filePath)) {
                // Successfully uploaded new file
            } else {
                throw new Exception("Une erreur est survenue lors du téléchargement du fichier.");
            }
        } else {
            // If no new file was uploaded, keep the existing one
            $currentCourse = getCoursById($id);
            $filePath = $currentCourse['fichier']; // Use existing file path if no new upload is made
        }

        // Update the course with the current or new file path
        updateCours($id, $Domaine_id, $nomCours, $filePath);
        
        header("Location: dashboard.php"); // Redirect after successful update
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Display error message
    }
}
// Fetch all courses for display
$cours = readCours(); // Fetch all courses

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Dashboard</title>
   <link href="/Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
   <link href="Templates/css/sb-admin-2.css" rel="stylesheet">
   <style>
       body { background-color: #f8f9fc; }
       .container-fluid { margin-top: 20px; }
       .form-group { margin-bottom: 15px; }
       .table th, .table td { vertical-align: middle; }
       .form-heading { color: #007bff; }
       .btn-success { background-color: #007bff; border-color: #007bff; }
       .btn-warning { background-color: #ffc107; border-color: #ffc107; }
       .error-message { color: red; margin-top: 10px; }
   </style>
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
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
</ul>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">EYA MARIEM EZZAIER</span>
                <img class="img-profile rounded-circle" src="img/eyaa.png">
            </a>
            <div class='dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='userDropdown'>
                <a class='dropdown-item' href='#'><i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i> Profil</a>
                <a class='dropdown-item' href='#'><i class='fas fa-cogs fa-sm fa-fw mr-2 text-gray-400'></i> Paramètres</a>
                <div class='dropdown-divider'></div>
                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'><i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i> Déconnexion</a>
            </div>
        </li>
    </ul>
</nav>

<!-- Begin Page Content -->
<div class='container-fluid'>  
<h1 class='h3 mb-4 text-gray-800'>Domaines</h1>

<!-- Create or Edit Domain Form -->
<form method='POST' enctype='multipart/form-data' onsubmit='return validateForm()' class='mb-4'>
<?php if ($domaineToEdit): ?>
<h4 class='form-heading'>Modifier le domaine</h4>
<input type='hidden' name='id' value='<?php echo htmlspecialchars($domaineToEdit['id']); ?>'>
<?php else: ?>
<h4 class='form-heading'>Créer un nouveau domaine</h4>
<?php endif; ?>
<div class='form-group'>
<label for='name'>Nom:</label>
<input type='text' name='name' id='name' placeholder='Entrez le nom du domaine' class='form-control' value="<?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['name']) : ''; ?>">
<div id='nameError' class='error-message'></div>
</div>

<div class='form-group'>
<label for='description'>Description:</label>
<textarea name='description' id='description' placeholder='Entrez la description du domaine' class='form-control'><?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['description']) : ''; ?></textarea>
<div id='descriptionError' class='error-message'></div>
</div>

<div class='form-group'>
<label for='competence'>Compétence:</label>
<input type='text' name='competence' id='competence' placeholder='Entrez la compétence associée' class='form-control' value="<?php echo isset($domaineToEdit) ? htmlspecialchars($domaineToEdit['competence']) : ''; ?>">
<div id='competenceError' class='error-message'></div>
</div>

<div class='form-group'>
<label for='image'>Image:</label>
<input type='file' name='image' id='image' accept='.jpg,.jpeg,.png,.gif' class='form-control-file'>
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
<td><?php echo htmlspecialchars($domaine['name']); ?></td>
<td><?php echo htmlspecialchars($domaine['description']); ?></td>
<td><?php echo htmlspecialchars($domaine['competence']); ?></td>
<td><img src="<?php echo htmlspecialchars($domaine['image']); ?>" alt="<?php echo htmlspecialchars($domaine['name']); ?>" style='width: 100px;'></td>
<td>
<a href="?edit=<?php echo htmlspecialchars($domaine['id']); ?>" class="btn btn-warning btn-sm">Modifier</a> 
<a href="?delete=<?php echo htmlspecialchars($domaine['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce domaine ?');">Supprimer</a></td></tr><?php endforeach; ?>
</tbody></table>

<!-- Cours Section -->
<h1 class='h3 mb-4 text-gray-800'>Cours</h1>

<form method='POST' enctype='multipart/form-data' onsubmit="return validateCourseForm();" class='mb-4'>
<h4 class='form-heading'>Créer un nouveau cours</h4>

<div class='form-group'>
<label for='Domaine_id'>Domaine:</label>
<select name='Domaine_id' id='Domaine_id' class='form-control'>
<option value='' disabled selected>Sélectionnez un domaine</option> <!-- Added disabled attribute -->
<?php foreach ($domaines as $domaine): ?>
<option value='<?php echo htmlspecialchars($domaine['id']); ?>'><?php echo htmlspecialchars($domaine['name']); ?></option><?php endforeach; ?>
</select><div id='domainError' class='error-message'></div></div>

<div class='form-group'>
<label for='nomCours'>Nom du cours:</label><input type='text'
name= 'nomCours'
id= 'nomCours'
placeholder= 'Entrez le nom du cours'
class= 'form-control'
value="<?php echo isset($courseToEdit) ? htmlspecialchars($courseToEdit['nom']) : ''; ?>">
<div id= 'courseNameError'
class= 'error-message'></div></div>

<div class= 'form-group'><label for= 'fichier'>Fichier:</label><input type= 'file'
name= 'fichier'
id= 'fichier'
accept= '.pdf,.doc,.docx'
class= 'form-control'><div id= 'fileError'
class= 'error-message'></div></div>

<?php if ($courseToEdit): ?>
<input type="hidden" name="id" value="<?php echo htmlspecialchars($courseToEdit['id_cours']); ?>">
<button type='submit' name='updatecours' class='btn btn-warning btn-block'>Mettre à jour le cours</button>
<?php else: ?>
<button type='submit' name='createcours' class='btn btn-success btn-block'>Créer Cours</button>
<?php endif; ?>
</form>

<h4>Liste des Cours</h4><table class='table table-striped'><thead><tr><th>ID</th><th>Nom</th><th>Fichier</th><th>Domaine</th><th>Actions</th></tr></thead><tbody><?php foreach ($cours as $course): ?><?php $domaine = getDomaineById($course ['Domaine_id']); ?><tr><td><?php echo htmlspecialchars($course ['id_cours']); ?></td><td><?php echo htmlspecialchars ($course ['nom']); ?></td><td><a href="<?php echo htmlspecialchars ($course ['fichier']); ?>">Télécharger</a></td><td><?php echo htmlspecialchars ($domaine ['name']); ?></td><td><a href="?editcours=<?php echo htmlspecialchars ($course ['id_cours']); ?>"class ="btn btn-warning btn-sm">Modifier </a> 
<a href="?deletecours=<?php echo htmlspecialchars ($course ['id_cours']); ?>"class ="btn btn-danger btn-sm" onclick ="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">Supprimer </a></td></tr><?php endforeach; ?></tbody></table></div><!-- End of Main Content -->

<!-- Footer -->
<footer class ="sticky-footer bg-white"><div 
class ="container my-auto"><div 
class ="copyright text-center my-auto"><span>© 2023 MonSite </span></div></div></footer><!-- End of Footer -->


<script src="../../Templates/vendor/jquery/jquery.min.js"></script>
<script src="../../Templates/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../Templates/js/sb-admin-2.min.js"></script>
<script>
function validateForm() {
let isValid = true;

const nameInput = document.getElementById('name');
const descriptionInput = document.getElementById('description');
const imageInput = document.getElementById('image');
const competenceInput = document.getElementById('competence');

const nameError = document.getElementById('nameError');
const descriptionError = document.getElementById('descriptionError');
const imageError = document.getElementById('imageError');

// Reset error messages
nameError.textContent = '';
descriptionError.textContent = '';
competenceError.textContent = '';
imageError.textContent = '';
competenceError.textContent = '';

// Validate name field
if (nameInput.value.trim() === '') {
nameError.textContent = 'Le nom est requis.';
isValid = false;
} else if (nameInput.value.length < 3 || nameInput.value.length > 50) {
nameError.textContent = 'Le nom doit contenir entre 3 et 50 caractères.';
isValid = false;
}

// Validate description field
if (descriptionInput.value.trim() === '') {
descriptionError.textContent = 'La description est requise.';
isValid = false;
}
// Validate competence field
if (competenceInput.value.trim() === '') {
competenceError.textContent = 'entrer au moins une competence.';
isValid = false;
}
    // Validate image only if creating a new domain
    const isEditing = <?php echo json_encode($domaineToEdit ? true : false); ?>;
    if (!isEditing) {
        const imageInput = document.getElementById('image');
        if (imageInput.files.length === 0) {
            document.getElementById('imageError').innerText = 'Une image est requise.';
            isValid = false;
        }
    }

return isValid; // Return overall validity of the form 
}
function validateCourseForm() {
    let nomCours = document.getElementById('nomCours').value;
    let domaineId = document.getElementById('Domaine_id').value;
    let fichier = document.getElementById('fichier').value;
    let valid = true;

    // Clear previous error messages
    document.getElementById('courseNameError').innerText = '';
    document.getElementById('domainError').innerText = '';
    document.getElementById('fileError').innerText = '';

    // Validate course name
    if (nomCours.length < 3 || nomCours.length > 50) {
        document.getElementById('courseNameError').innerText = 'Le nom du cours doit contenir entre 3 et 50 caractères.';
        valid = false;
    }

    // Validate domaine selection
    if (domaineId === '') {
        document.getElementById('domainError').innerText = 'Veuillez sélectionner un domaine.';
        valid = false;
    }

    // Validate file
    if (fichier === '') {
        document.getElementById('fileError').innerText = 'Veuillez sélectionner un fichier.';
        valid = false;
    }

    return valid; // Return the validation result
}
</script>

</body>
</html> 
