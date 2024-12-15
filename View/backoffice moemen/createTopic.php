<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create Topic</title>

    <!-- Custom fonts for this template-->
    <link href="./backoffice/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./backoffice/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <!-- Page Wrapper -->
    <div id="wrapper">

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
            <li class="nav-item">
                <a class="nav-link" href="../backoff/dashboard.php">
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
                        <a class="collapse-item" href="topicsList.php">Topics List</a>
                        <a class="collapse-item active" href="createTopic.php">Create Topic</a>
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
            </div>

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

                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="./backoffice/img/undraw_profile.svg">
                            </a>
                            
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card container mt-4">
                    <div class="card-title">
                        <br>
                        <h1 class="text-center m-2">Add Topic</h1>
                    </div>
                    <form class="card-body" method="POST" action="addTopic.php" id="inscription">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                id="title" name="title" placeholder="Enter Title..."  >
                        </div>
                        <div class="form-group">
                            <textarea class="form-control form-control-user" 
                                id="description" name="description" placeholder="Enter Description..." rows="4" ></textarea>
                        </div>
                        <a class="btn btn-primary btn-user" class="btn btn-primary btn-user" style="width: auto; height: auto; padding: 8px 16px; font-size: 14px; " href="api.php">
                            Génerer une description
                        </a>

                        <br> <br>
                        <div class="form-group">
                            <textarea class="form-control form-control-user"
                                id="content" name="content" placeholder="Enter Content..." rows="4" ></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                id="videolink" name="videolink" placeholder="Enter Video Link..." >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                id="imageurl" name="imageurl" placeholder="Enter Image URL..." >
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Add Topic
                        </button>
                    </form>
                    <p style="color: red;" id="erreur" align="center"></p>
                </div>
                <script src="scripttopic.js"></script>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
