<?php
require_once '../../controller/UserController.php';
require_once '../../controller/ProfileController.php';

session_start();

// Redirect to login if not logged in or not an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 1) {
    header("location: ../frontOffice_zeineb/login.php");
    exit;
}

// Initialize controllers
$user_controller = new UserController();
$profile_controller = new ProfileController();
$list2 = $profile_controller->listProfile();

// Get current page from query parameters
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure the page is at least 1

// Retrieve search keyword and filters from query parameters
$keyword = isset($_GET['keyword']) ? trim(filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING)) : "";
$is_search = !empty($keyword);

$sort_order = isset($_GET['sort_order']) && in_array($_GET['sort_order'], ['asc', 'desc']) ? $_GET['sort_order'] : 'desc';
$role_filter = isset($_GET['role_filter']) ? trim($_GET['role_filter']) : '';

// Pagination setup
$items_per_page = 5;
$offset = ($current_page - 1) * $items_per_page;

// Initialize data variables
$users_to_display = [];
$total_users = 0;

// Determine query based on search and filters
if ($is_search) {
    // If searching, apply search logic with optional filters and sorting
    $users_to_display = $user_controller->searchUsersWithFilters($keyword, $items_per_page, $offset, $sort_order, $role_filter);
    $total_users = count($user_controller->searchUsersWithFilters($keyword, PHP_INT_MAX, 0, $sort_order, $role_filter));
} else {
    // If no search, apply filters and sorting
    $users_to_display = $user_controller->getUsersPaginatedWithFilters($items_per_page, $offset, $sort_order, $role_filter);
    $total_users = count($user_controller->getUsersPaginatedWithFilters(PHP_INT_MAX, 0, $sort_order, $role_filter));
}

// Calculate total pages
$total_pages = ceil($total_users / $items_per_page);
$current_page = min($current_page, $total_pages); // Adjust page if it exceeds total pages



// Set the number of records per page
$recordsPerPage = 5;

// Get the current page from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the starting record for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// Get the total number of records
$totalRecords = $profile_controller->countProfiles(); // Assume `countProfiles` returns total profiles count
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch the profiles for the current page
$list2 = $profile_controller->getProfilesWithPagination($recordsPerPage, $offset); // Add method for paginated profiles

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
    <link href="Template/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .container {
            max-width: 1400px;
        }

        /* Add some style to the form */
        .header-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .filter-form label {
            font
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
            <header style="background-color: #f8f9fa;  border-bottom: 2px solid #dee2e6; text-align: center;">
                <h5 class="my-5" style="margin: 0; font-size: 1.5rem; color: #343a40;">
                    Bienvenue
                    <b style="color: #007bff;">
                        <?php echo htmlspecialchars($_SESSION['nom']) . ' ' . htmlspecialchars($_SESSION['prenom']); ?>
                    </b>
                    dans le back office.
                </h5>
            </header>

            <!-- Main Content -->
            <main class="container mt-5">
                <h2 class="mb-4">Tableau de Bord des Utilisateurs</h2>

                <!-- Search Section -->
                <form action="" method="GET">
                    <div class="input-group"">
                    <input type=" text" name="keyword" placeholder="Recherche de ..." class="form-control search"
                        aria-label="Search" aria-describedby="basic-addon2"
                        value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <div class="input-group-append">
                            <button type="submit" name="search" class="btn btn-primary"><i
                                    class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>

                <!-- Header Section -->
                <div class="header-section d-flex justify-content-between align-items-center">
                    <form method="GET" action="" class="filter-form">
                        <!-- Trier par date -->
                        <label for="sort_order">Trier par :</label>
                        <select name="sort_order" id="sort_order">
                            <option value="desc" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc')
                                echo 'selected'; ?>>Les plus récents</option>
                            <option value="asc" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc')
                                echo 'selected'; ?>>Les plus anciens</option>
                        </select>

                        <!-- Filtrer par rôle -->
                        <label for="role_filter">Rôle :</label>
                        <select name="role_filter" id="role_filter">
                            <option value="">Tous</option>
                            <option value="1" <?php if (isset($_GET['role_filter']) && $_GET['role_filter'] == '1')
                                echo 'selected'; ?>>Administrateur</option>
                            <option value="2" <?php if (isset($_GET['role_filter']) && $_GET['role_filter'] == '2')
                                echo 'selected'; ?>>Client</option>
                        </select>

                        <!-- Bouton de soumission -->
                        <button type="submit" class="btn btn-primary btn-sm">Appliquer</button>
                    </form>
                </div>



                <!-- Clients Table -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="header-section d-flex justify-content-between align-items-center">
                            <h3 class="mb-3">Liste des Utilisateurs</h3>
                            <a href="addUser.php">
                                <button class="btn btn-primary">Ajouter un utilisateur</button>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-responsive-sm" id="dataTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Mot de Passe</th>
                                        <th>Rôle</th>
                                        <th>Date d'Inscription</th>
                                        <th>Verification</th>
                                        <th colspan="2" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users_to_display as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['id']); ?></td>
                                            <td><?= htmlspecialchars($user['nom']); ?></td>
                                            <td><?= htmlspecialchars($user['prenom']); ?></td>
                                            <td><?= htmlspecialchars($user['email']); ?></td>
                                            <td><?= htmlspecialchars($user['password']); ?></td>
                                            <td><?= htmlspecialchars($user['role']); ?></td>
                                            <td><?= htmlspecialchars($user['date_creation']); ?></td>
                                            <td><?= htmlspecialchars($user['verification']); ?></td>
                                            <td>
                                                <a href="deleteUser.php?id=<?= htmlspecialchars($user['id']); ?>"
                                                    class="btn btn-danger btn-sm">Supprimer</a>
                                            </td>
                                            <td>
                                                <form method="POST" action="updateUser.php" class="d-inline">
                                                    <input type="hidden" name="id"
                                                        value="<?= htmlspecialchars($user['id']); ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($current_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="?page=<?= $current_page - 1; ?>&keyword=<?= htmlspecialchars($keyword); ?>&sort_order=<?= $sort_order; ?>&role_filter=<?= $role_filter; ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?= $i == $current_page ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="?page=<?= $i; ?>&keyword=<?= htmlspecialchars($keyword); ?>&sort_order=<?= $sort_order; ?>&role_filter=<?= $role_filter; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($current_page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="?page=<?= $current_page + 1; ?>&keyword=<?= htmlspecialchars($keyword); ?>&sort_order=<?= $sort_order; ?>&role_filter=<?= $role_filter; ?>"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>


                <!-- Profiles Table -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="mb-3 ">Liste des Profils des Utilisateurs</h3>
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID du Profil </th>
                                    <th scope="col">Id de l'Utilisateur</th>
                                    <th scope="col">Domaine</th>
                                    <th scope="col">Occupation</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Telephone</th>
                                    <th scope="col">Photo de Profil</th>
                                    <!-- <th colspan="2">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list2 as $profile): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($profile['id']); ?></td>
                                        <td><?= htmlspecialchars($profile['user_id']); ?></td>
                                        <td><?= htmlspecialchars($profile['domaine']); ?></td>
                                        <td><?= htmlspecialchars($profile['occupation']); ?></td>
                                        <td><?= htmlspecialchars($profile['age']); ?></td>
                                        <td><?= htmlspecialchars($profile['telephone']); ?></td>
                                        <td><?= htmlspecialchars($profile['photo_profil']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Links -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage - 1; ?>">&laquo;</a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage + 1; ?>">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

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

        <script>
            window.addEventListener("beforeunload", function () {
                sessionStorage.setItem("scrollPosition", window.scrollY);
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const scrollPosition = sessionStorage.getItem("scrollPosition");
                if (scrollPosition) {
                    window.scrollTo(0, parseInt(scrollPosition));
                }
            });
        </script>



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