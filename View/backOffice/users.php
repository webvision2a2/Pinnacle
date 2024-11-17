<?php
include '../../controller/UserController.php';
$user_controller = new UserController();
$list = $user_controller->listUser();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BackOffice - Utilisateurs</title>

    <!-- Custom fonts for this template-->
    <link href="Template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Template/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Template/scss/navs/_sidebar.scss">
    <style>
        .container {
            max-width: 1400px; 
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
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
        <div class="flex-grow-1"></=div>

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
        <main class="container mt-5" ">
            <!-- Header Section -->
            <div class="header-section d-flex justify-content-between align-items-center">
                <h2 class="mb-4">Tableau de Bord des Clients</h2>
                <a href="addUser.php">
                    <button class="btn btn-primary">Ajouter un utilisateur</button>
                </a>
            </div>

            <!-- Clients Table -->
            <div class="card mb-4" >
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID du Client</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Email</th>
                                <th scope="col">password</th>
                                <th scope="col">Rôle</th>
                                <th scope="col">Date d'Inscription</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $user) {
                            ?> 
                            <tr>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['nom']; ?></td>
                                <td><?= $user['prenom']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['password']; ?></td>
                                <td><?= $user['role']; ?></td>
                                <td><?= $user['date_creation']; ?></td>
                                <td>
                                    <a href="deleteUser.php?id=<?php echo $user['id']; ?>">Delete</a>
                                </td>
                                <td align="center">
                                    <form method="POST" action="updateUser.php">
                                        <input type="submit" name="update" value="Update">
                                        <input type="hidden" value=<?php echo $user['id']; ?> name="id">
                                    </form>
                                </td>
                            </tr> 
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="card" style="width: 1160px; padding: 20px;">
                <div class="card-body ">
                    <h2>Tableau de Bord des Statistiques Clients</h2>
                    <table class="table table-hover table-bordered mb-4">
                        <thead class="thead-light">
                            <tr>
                                <th>Statistique</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Clients</td>
                                <td id="totalClients">...</td>
                            </tr>
                            <tr>
                                <td>Clients Actifs</td>
                                <td id="activeClients">...</td>
                            </tr>
                            <tr>
                                <td>Clients Inactifs</td>
                                <td id="inactiveClients">...</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Charts Section -->
                    <div class="charts d-flex">
                        <div class="chart-container me-4">
                            <h3>Inscriptions par Mois</h3>
                            <canvas id="inscriptionsChart"></canvas>
                        </div>
                        <div class="chart-container">
                            <h3>Répartition des Domaines des Clients</h3>
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>


               
            

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="Template/vendor/jquery/jquery.min.js"></script>
    <script src="Template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Template/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="Template/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="Template/js/demo/chart-area-demo.js"></script>
    <script src="Template/js/demo/chart-pie-demo.js"></script>
    <script src="Template/js/demo/chart-bar-demo.js"></script>

</body>

</html>