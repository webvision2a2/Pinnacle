<?php
// dashboard.php

// Include the database connection and CRUD functions with correct paths
include '../../Models/Database.php';
include '../../Controller/CRUD.php'; // Adjust path as necessary

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission for creating a new domaine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    // Validate domain name
    if (empty($_POST['name']) || strlen($_POST['name']) < 3 || strlen($_POST['name']) > 50) {
        $errorMessage = "Le nom du domaine doit contenir entre 3 et 50 caractères.";
    } else {
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "../../view/backoff/Templates/uploads/"; // Directory where images will be stored
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);

            // Check if uploads directory exists, if not create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true); // Create directory with appropriate permissions
            }

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Add domaine with image path
                addDomaines($_POST['name'], $_POST['description'], $targetFile);
                header("Location:dashboard.php"); // Redirect after successful upload
                exit;
            } else {
                echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
            }
        } else {
            echo "Aucune image téléchargée ou une erreur de téléchargement s'est produite.";
        }
    }
}

// Handle deletion of a domaine
if (isset($_GET['delete'])) {
    deletedomaines($_GET['delete']);
}

// Fetch all domaines for display
try { 
    $domaines = readdomaines(); 
} catch (Exception $e) {
    echo "Erreur lors de la récupération des domaines : " . htmlspecialchars($e->getMessage());
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

    // Update the domaine with or without the new image path
    updatedomaines($id, $name, $description, $image);
    
    header("Location: dashboard.php"); // Redirect after successful update
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Dashboard</title>

   <!-- Custom fonts for this template -->
   <link href="/Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="Templates/css/sb-admin-2.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">   
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
<li class="nav-item">
    <a class="nav-link" href="../pages.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>tableau de bord</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../pages.html">
        <i class="fas fa-fw fa-user"></i>
        <span>utulisateurs</span>
    </a>
</li>
<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="../../view/backoff/dashboard.php">
        <i class="fas fa-fw fa-book"></i>
        <span>catalogue</span>
    </a>
</li>

<!-- Other Nav Items -->
<li class="nav-item">
    <a class="nav-link" href="../pages.html"><i class="fas fa-fw fa-comments">

</i><span>entretien</span>
</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../pages.html">
        <i class="fas fa-fw fa-heart"></i>
        <span>psychologie</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../tables.html">
        <i class="fas fa-fw fa-network-wired"></i><span>Reseau</span></a></li>
<li class="nav-item">
    <a class="nav-link" href="../tables.html">
        <i class="fas fa-fw fa-table">
        </i>
        <span>evenements</span></a></li>

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

<!-- Display error message if exists -->
<?php if (!empty($errorMessage)): ?>
<div class='error-message'><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>

<div class='form-group'>
<label for='name'>Nom:</label>
<input type='text' name='name' id='name' placeholder='Entrez le nom du domaine' value='<?php echo htmlspecialchars($domaineToEdit ? htmlspecialchars($domaineToEdit['name']) : ''); ?>' class='form-control'>
<div id='nameError' class='error-message'></div> <!-- Error message for name -->
</div>

<div class='form-group'>
<label for='description'>Description:</label>
<textarea name='description' id='description' placeholder='Entrez la description du domaine' class='form-control'><?php echo htmlspecialchars($domaineToEdit ? htmlspecialchars($domaineToEdit['description']) : ''); ?></textarea>
<div id='descriptionError' class='error-message'></div> <!-- Error message for description -->
</div>

<div class='form-group'>
    <label for='image'>Image:</label>
    <input type='file' name='image' id='image' accept='.jpg,.jpeg,.png,.gif' class='form-control-file'>
    <div id='imageError' class='error-message'></div> <!-- Error message for image -->
</div>
<?php if ($domaineToEdit): ?>
<button type='submit' name='update' class='btn btn-warning btn-block'>Mettre à jour</button>
<?php else: ?>
<button type='submit' name='create' class='btn btn-success btn-block'>Créer</button>
<?php endif; ?>
</form>

<h4>Liste des domaines</h4>
<table class='table table-striped'>
<thead><tr><th>ID</th><th>Nom</th><th>Description</th><th>Image</th><th>Actions</th></tr></thead>
<tbody><?php foreach ($domaines as $domaine): ?>
<tr><td><?php echo htmlspecialchars($domaine['id']); ?></td><td><?php echo htmlspecialchars($domaine['name']); ?></td><td><?php echo htmlspecialchars($domaine['description']); ?></td><td><img src="<?php echo htmlspecialchars($domaine['image']); ?>" alt="<?php echo htmlspecialchars($domaine['name']); ?>" style='width: 100px;'></td><td><!-- Edit Link --><a href="?edit=<?php echo htmlspecialchars($domaine['id']); ?>"class='btn btn-warning btn-sm'>Modifier</a>| <!-- Delete Link --><a href="?delete=<?php echo htmlspecialchars($domaine['id']); ?>" onclick='return confirm("Êtes-vous sûr de vouloir supprimer ce domaine ?");'class='btn btn-danger btn-sm'>Supprimer</a></td></tr><?php endforeach; ?></tbody></table></div><!-- /.container-fluid -->

<!-- Footer -->
<footer class='sticky-footer bg-white'>...</footer><!-- End of Footer -->

<!-- Scripts -->
<script src='../Templates/vendor/jquery/jquery.min.js'></script>
<script src='../Templates/vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
<script src='../Templates/vendor/jquery-easing/jquery.easing.min.js'></script>
<script src='../Templates/js/sb-admin-2.min.js'></script>

<script>
// JavaScript validation function for the form
function validateForm() {
let isValid = true;

const nameInput = document.getElementById('name');
const descriptionInput = document.getElementById('description');
const imageInput = document.getElementById('image');

const nameError = document.getElementById('nameError');
const descriptionError = document.getElementById('descriptionError');
const imageError = document.getElementById('imageError');

// Reset error messages
nameError.textContent = '';
descriptionError.textContent = '';
imageError.textContent = '';

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

</script>

</body></html>
