<?php
require_once '../../Controller/SocieteController.php';

$error = "";
$societe = null;

// create an instance of the controller
$societeController = new SocieteController();

if (
  isset($_POST["id"]) && isset($_POST["nom_soc"]) && isset($_POST["adresse"]) && isset($_POST["numero"]) && isset($_POST["email"]) && isset($_POST["speciality"])
) {
  if (
    !empty($_POST["id"]) && !empty($_POST["nom_soc"]) && !empty($_POST["adresse"]) && !empty($_POST["numero"]) && !empty($_POST["email"]) && !empty($_POST["speciality"])
  ) {
    $specialities = is_array($_POST['speciality']) ? implode(",", $_POST['speciality']) : $_POST['speciality'];
    $societe = new Societe(
      $_POST['id'],
      $_POST['nom_soc'],
      $_POST['adresse'],
      $_POST['numero'],
      $_POST['email'],
      $specialities
    );

    $updateResult = $societeController->updateSociete($societe, $_POST['id']);

    if ($updateResult) {
      // Redirect to societe list on successful update
      header('Location: main2.php');
    } else {
      // Handle update failure (e.g., database error)
      $error = "Error updating company information";
    }
  } else {
    $error = "Missing information";
  }
}

// Display the update form if an ID is present in POST data
if (isset($_POST['id'])) {
  $societe = $societeController->showSociete($_POST['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Update Company - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">Business Directory <sup></sup></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="main2.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="societeList.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Back to Company List</span>
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
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Update the Company with Id = <?php echo $_POST['id'] ?></h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Card Example -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <?php
                                            if ($societe) {
                                        ?>
                                        <form align="center" action="" method="POST">
                                            <!-- ID -->
                                            <div class="mb-3">
                                                <label for="id" class="form-label">ID Societe :</label>
                                                <input type="text" class="form-control" id="id" name="id" readonly value="<?php echo $_POST['id'] ?>">
                                            </div>
                                            
                                            <!-- Company Name -->
                                            <div class="mb-3">
                                                <label for="nom_soc" class="form-label">Nom de la Société :</label>
                                                <input type="text" class="form-control" id="nom_soc" name="nom_soc" value="<?php echo $societe['nom_soc'] ?>">
                                            </div>
                                            <h6 id="1" class="text-danger"></h6>
                                            <h6 id="2" class="text-success"></h6>
                                            
                                            <!-- Company Address -->
                                            <div class="mb-3">
                                                <label for="adresse" class="form-label">Adresse Physique de la Société :</label>
                                                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $societe['adresse'] ?>">
                                            </div>
                                            <h6 id="3" class="text-danger"></h6>
                                            <h6 id="4" class="text-success"></h6>
                                            
                                            <!-- Phone Number -->
                                            <div class="mb-3">
                                                <label for="numero" class="form-label">Numéro de Téléphone de la Société :</label>
                                                <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $societe['numero'] ?>">
                                            </div>
                                            <h6 id="5" class="text-danger"></h6>
                                            <h6 id="6" class="text-success"></h6>
                                            
                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Adresse Email de la Société :</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $societe['email'] ?>">
                                            </div>
                                            <h6 id="7" class="text-danger"></h6>
                                            <h6 id="8" class="text-success"></h6>

                                            <!-- Specialities -->
                                            <div class="form-group">
                                                <label for="speciality" class="form-label">Les domaines de la Société :</label>
                                                <select class="form-control" id="speciality" name="speciality[]" multiple>
                                                    <option value="web" <?php echo (strpos($societe['speciality'], 'web') !== false) ? 'selected' : ''; ?>>Développement Web</option>
                                                    <option value="design" <?php echo (strpos($societe['speciality'], 'design') !== false) ? 'selected' : ''; ?>>Design</option>
                                                    <option value="dev_log" <?php echo (strpos($societe['speciality'], 'dev_log') !== false) ? 'selected' : ''; ?>>Développement de Logiciels</option>
                                                    <option value="sec" <?php echo (strpos($societe['speciality'], 'sec') !== false) ? 'selected' : ''; ?>>Sécurité Informatique</option>
                                                    <option value="reseau" <?php echo (strpos($societe['speciality'], 'reseau') !== false) ? 'selected' : ''; ?>>Réseaux et Télécommunications</option>
                                                    <option value="ai" <?php echo (strpos($societe['speciality'], 'ai') !== false) ? 'selected' : ''; ?>>Intelligence Artificielle (IA)</option>
                                                    <option value="data_science" <?php echo (strpos($societe['speciality'], 'data_science') !== false) ? 'selected' : ''; ?>>Data Science</option>
                                                    <option value="cloud" <?php echo (strpos($societe['speciality'], 'cloud') !== false) ? 'selected' : ''; ?>>Informatique en Nuage (Cloud Computing)</option>
                                                    <option value="vr_ar" <?php echo (strpos($societe['speciality'], 'vr_ar') !== false) ? 'selected' : ''; ?>>Réalité Virtuelle (VR) et Réalité Augmentée (AR)</option>
                                                    <option value="ad_sys" <?php echo (strpos($societe['speciality'], 'ad_sys') !== false) ? 'selected' : ''; ?>>Administration des Systèmes</option>
                                                    <option value="bigdata" <?php echo (strpos($societe['speciality'], 'bigdata') !== false) ? 'selected' : ''; ?>>Big Data</option>
                                                    <option value="dev_mobile" <?php echo (strpos($societe['speciality'], 'dev_mobile') !== false) ? 'selected' : ''; ?>>Développement Mobile</option>
                                                    <option value="robotics" <?php echo (strpos($societe['speciality'], 'robotics') !== false) ? 'selected' : ''; ?>>Robotics</option>
                                                    <option value="iot" <?php echo (strpos($societe['speciality'], 'iot') !== false) ? 'selected' : ''; ?>>Internet des Objets (IoT)</option>
                                                </select>
                                            </div>
                                            <h6 id="9" class="text-danger"></h6>
                                            <h6 id="10" class="text-success"></h6>


                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary" id="button" name="submit">Update</button>
                                        </form>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
            </div>
        </div>
    </div>
    <!-- Bootstrap JS, jQuery, and other dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
