<?php

include '../../Controller/UserController.php';


$error = "";

$user= null;

$userController = new UserController();


if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"])) {
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"])) {
        
        if (!empty($_POST["password"])) {
            /* $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT); */
            $hashed_password = $_POST["password"];
        } else {
            $hashed_password = $userController->getUserPassword($_POST['id']);
        }
        
        $date_creation = date('Y-m-d H:i:s');
        
        $user = new User(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $hashed_password, 
            $_POST['role'],
            new DateTime($date_creation),
            $_POST['verification']
        );

        $userController->updateUser($user, $_POST['id']);
        header('Location:users.php');
    } else {
        $error = "Missing information";
    }
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

    <title>Modifier un Utilisateur</title>

    <!-- Custom fonts for this template-->
    <link href="Template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Template/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon">
                    <img class="logo" src="../frontOffice/Template/img/LOGO white.png" alt="Pinnacle Logo" style="max-width: 30px;">
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
            <li class="nav-item active">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item">
                <a class="nav-link" href="messages.html">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>

            <!-- Nav Item - Catalogue -->
            <li class="nav-item">
                <a class="nav-link" href="catalogue.html">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Catalogue</span>
                </a>
            </li>

            <!-- Nav Item - Entretien -->
            <li class="nav-item">
                <a class="nav-link" href="entretien.html">
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Entretients</span>
                </a>
            </li>

            <!-- Nav Item - Ateliers -->
            <li class="nav-item">
                <a class="nav-link" href="ateliers.html">
                    <i class="fas fa-fw fa-chalkboard"></i>
                    <span>Ateliers</span>
                </a>
            </li>

            <!-- Nav Item - Stages -->
            <li class="nav-item">
                <a class="nav-link" href="stages.html">
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Stages</span>
                </a>
            </li>

            <!-- Nav Item - Événements -->
            <li class="nav-item">
                <a class="nav-link" href="events.html">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Événements</span>
                </a>
            </li>



            <!-- Spacer to push items to top -->
            <div class="flex-grow-1"></div>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Se Déconnecter Button -->
            <li class="nav-item">
                <a class="nav-link" href="login.html">
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
                    <!-- Your Topbar Code Here -->
                </nav>
                <!-- End of Topbar -->




                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Modifier un Utilisateur</h1>

                    <!-- Form Section -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php
                                if (isset($_POST['id'])) {
                                    $user = $userController->showUser($_POST['id']);
                                
                            ?>
                            <form id="signupForm" action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['nom']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de Passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Laissez vide pour ne pas changer">
                                </div>
                                <div class="form-group">
                                    <label for="role">Rôle</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="1" <?php if ($user['role'] == 1) echo 'selected'; ?>>Admin</option>
                                        <option value="2" <?php if ($user['role'] == 2) echo 'selected'; ?>>Client</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="verification">verification</label>
                                    <select class="form-control" id="verification" name="verification">
                                        <option value="1" <?php if ($user['verification'] == 1) echo 'selected'; ?>>Verifié</option>
                                        <option value="0" <?php if ($user['verification'] == 0) echo 'selected'; ?>>Non Verifié</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="users.php" class="btn btn-secondary">Annuler</a>
                            </form>

                            <?php
                                }
                            ?>
                            <p><?php echo $error ?> </p>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

   <!--  <script src="js/addUser.js"></script> -->

    <!-- Bootstrap core JavaScript-->
    <script src="Template/vendor/jquery/jquery.min.js"></script>
    <script src="Template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Template/js/sb-admin-2.min.js"></script>
</body>

</html>
