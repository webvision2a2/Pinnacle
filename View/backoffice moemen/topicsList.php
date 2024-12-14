<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Topics list </title>

    <!-- Custom fonts for this template -->
    <link href="./backoffice/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./backoffice/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="./backoffice/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> PINNACLE</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Topicslist -->
            <li class="nav-item">
                <a class="nav-link" href="topicsList.php">
                <i class="fas fa-fw fa-table"></i></i>
                    <span>Topics List</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="createTopic.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Create Topic</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
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

                <?php
                require_once '../../Controller/topicController.php';

                $topicController = new TopicController();

                // Paramètres par défaut
                $defaultItemsPerPage = 10;

                // Récupérer les paramètres
                $itemsPerPage = isset($_GET['itemsPerPage']) ? intval($_GET['itemsPerPage']) : $defaultItemsPerPage;
                $itemsPerPage = in_array($itemsPerPage, [10, 15, 20]) ? $itemsPerPage : $defaultItemsPerPage;

                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

                $offset = ($page - 1) * $itemsPerPage;

                // Obtenez les résultats en fonction de la recherche et de la pagination
                $topics = $topicController->getTopicsWithSearch($searchQuery, $itemsPerPage, $offset);
                $totalTopics = $topicController->countTopicsWithSearch($searchQuery);

                $totalPages = ceil($totalTopics / $itemsPerPage);
                ?>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <!-- En-tête -->
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Topics List</h6>

                            <!-- Barre de recherche -->
                            <form method="GET" class="d-flex">
                                <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" 
                                    class="form-control" placeholder="Search topics...">
                                <input type="hidden" name="itemsPerPage" value="<?php echo $itemsPerPage; ?>">
                                <button type="submit" class="btn btn-primary ms-2">Search</button>
                            </form>

                            <!-- Sélecteur pour le nombre d'éléments par page -->
                            <form method="GET" class="ms-3">
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                                <label for="itemsPerPage" class="me-2">Items per page:</label>
                                <select name="itemsPerPage" id="itemsPerPage" class="form-select form-select-sm d-inline-block w-auto">
                                    <option value="10" <?php if ($itemsPerPage == 10) echo 'selected'; ?>>10</option>
                                    <option value="15" <?php if ($itemsPerPage == 15) echo 'selected'; ?>>15</option>
                                    <option value="20" <?php if ($itemsPerPage == 20) echo 'selected'; ?>>20</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                            </form>
                        </div>

                        <!-- Table des résultats -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Title</th>
                                            <th>Description</th>

                                            <th colspan="2" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if (!empty($topics)): ?>
                                            <?php foreach ($topics as $topic): ?>
                                                <tr>
                                                    <td class="text-center"><?php echo htmlspecialchars($topic['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($topic['title']); ?></td>
                                                    <td><?php echo htmlspecialchars($topic['description']); ?></td>
                                                    <td class="text-center">
                                                        <a href="updateTopic.php?id=<?php echo htmlspecialchars($topic['id']); ?>">
                                                            <button class="btn btn-sm btn-warning">Edit</button>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="deleteTopic.php?id=<?php echo htmlspecialchars($topic['id']); ?>">
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No topics found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=1&itemsPerPage=<?php echo $itemsPerPage; ?>&search=<?php echo urlencode($searchQuery); ?>">First</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search=<?php echo urlencode($searchQuery); ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php
                                    // Raccourcir la pagination
                                    $visiblePages = 5; // Nombre de pages visibles
                                    $startPage = max(1, $page - floor($visiblePages / 2));
                                    $endPage = min($totalPages, $startPage + $visiblePages - 1);

                                    if ($startPage > 1): ?>
                                        <li class="page-item"><span class="page-link">...</span></li>
                                    <?php endif; ?>

                                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search=<?php echo urlencode($searchQuery); ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($endPage < $totalPages): ?>
                                        <li class="page-item"><span class="page-link">...</span></li>
                                    <?php endif; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search=<?php echo urlencode($searchQuery); ?>">Next</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $totalPages; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search=<?php echo urlencode($searchQuery); ?>">Last</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>




                                        
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

    <script src="./backoffice/vendor/jquery/jquery.min.js"></script>
    <script src="./backoffice/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./backoffice/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./backoffice/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./backoffice/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="./backoffice/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="./backoffice/js/demo/datatables-demo.js"></script>
    

</body>

</html>