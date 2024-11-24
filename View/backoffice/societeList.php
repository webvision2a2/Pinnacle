<?php
require_once '../../controller/SocieteController.php';
$societeController = new SocieteController();
$list = $societeController->listSociete();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Company List - Dashboard</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Company List</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nom de la Société</th>
                                                    <th>Adresse</th>
                                                    <th>Numéro de Téléphone</th>
                                                    <th>Email</th>
                                                    <th>Domaine</th>
                                                    <th colspan="2">Actions</th>
                                                </tr>
                                                <?php
                                                    foreach ($list as $societe) {
                                                ?> 
                                                <tr>
                                                    <td><?= $societe['id']; ?></td>
                                                    <td><?= $societe['nom_soc']; ?></td>
                                                    <td><?= $societe['adresse']; ?></td>
                                                    <td><?= $societe['numero']; ?></td>
                                                    <td><?= $societe['email']; ?></td>
                                                    <td><?= $societe['speciality']; ?></td>
                                                    <td align="center">
                                                        <form method="POST" action="updateSociete.php">
                                                            <input class="btn btn-primary" type="submit" name="update" value="Update">
                                                            <input type="hidden" value=<?= $societe['id']; ?> name="id">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger" href="deleteSociete.php?id=<?= $societe['id']; ?>" role="button">Delete</a>
                                                    </td>
                                                </tr>
                                                
                                                
                                                <?php
                                                    }
                                                ?>
                                            </table>
                                            <a class="btn btn-primary" href="main2.php" role="button">Add Company</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- End of Main Content -->

                <!-- Footer 
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Business Directory 2024</span>
                        </div>
                    </div>
                </footer>
                 End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
       
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>
        <script src="index.js"></script>

    </body>
</html>
