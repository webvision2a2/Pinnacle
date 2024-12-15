<?php
include '../../Controller/quizController.php';
include '../../Controller/userQuizController.php';

// Initialize controllers
$quizController = new QuizController();
$userQuizController = new UserQuizController();

// Initialize the UserController
$userController = new UserController();

// Fetch all user IDs
$userIds = $userController->fetchAllUserIds();

// Fetch user ID dynamically (default: 1 if not set)
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 47;

// Fetch user quizzes
$userQuizzes = $userQuizController->listUserQuizzes($userId);

$quizDataByUsers = []; // Array to store quiz data for each user
// Prepare data for Chart.js
$chartData = [
    'labels' => [], // User names
    'scores' => [], // Average scores per user
    'attempts' => [], // Total attempts per user
];

foreach ($userIds as $id) {
    $userQuizzes = $userQuizController->listUserQuizzes($id);

    $totalScore = 0;
    $totalAttempts = 0;
    $quizCount = count($userQuizzes);

    foreach ($userQuizzes as $quiz) {
        $totalScore += $quiz['score'];
        $totalAttempts += $quiz['attempts'];
    }

    // Populate the chart data
    $chartData['labels'][] = $userController->fetchNameByUserId($id); // User's name
    $chartData['scores'][] = $quizCount > 0 ? round($totalScore / $quizCount, 2) : 0; // Average score
    $chartData['attempts'][] = $totalAttempts; // Total attempts
}

// Encode data for JavaScript
$jsonChartData = json_encode($chartData);
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="template/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .chart-wrapper {
            display: flex;
            justify-content: flex-start; /* Align items horizontally with even spacing */
            align-items: flex-start; /* Align items to the top */
            gap: 20px; /* Space between the chart cards */
            margin-top: 20px;
            padding: 20px;
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
        }

        .chart-card {
            background-color: #ffffff; /* White background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Padding inside the card */
            width: 530px; /* Fixed width for each card */
            text-align: center; /* Center align content */
            transition: transform 0.2s; /* Smooth hover effect */
        }

        .chart-card:hover {
            transform: scale(1.05); /* Slight zoom on hover */
        }

        .chart-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px; /* Space between title and chart */
            color: #333;
        }

        .chart-card canvas {
            max-width: 100%; /* Responsive chart width */
            height: 250px; /* Fixed chart height */
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
                        <a class="collapse-item active" href="listQuiz.php">Quiz</a>
                        <a class="collapse-item" href="listUserQuiz.php">Utilisateurs</a>
                        <a class="collapse-item" href="listFeedback.php">Feedbacks</a>
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
<li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Reseaux</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="../backofficeahmed/main.php">Stages</a>
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

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - Alerts -->
              

                <!-- Nav Item - Messages -->
         

                <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administarteur #1</span>
                                <img class="img-profile rounded-circle"
                                    src="template/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de Bord Consolidé des Quiz</h1>
    </div>

    <!-- User Selection and Search Bar -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des Utilisateurs</h6>
        </div>
        <div class="card-body">
            <form class="form-row">
                <!-- Search Bar -->
                <div class="col-md-6 mb-3">
                    <input type="text" id="searchFilter" class="form-control" 
                           onkeyup="filterUsers()" placeholder="Rechercher un utilisateur par nom..." />
                </div>

                <!-- User Selection Dropdown -->
                <div class="col-md-6 mb-3">
                    <select id="userSelect" class="form-control" onchange="updateUserSelection()">
                        <option value="" disabled selected>Sélectionnez un utilisateur</option>
                        <?php foreach ($userIds as $id): ?>
                            <option value="<?php echo $id; ?>" <?php echo ($userId == $id) ? 'selected' : ''; ?>>
                                <?php echo $userController->fetchNameByUserId($id); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart Display -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Performance des Quiz</h6>
        </div>
        <div class="card-body">
           
                <canvas id="quizChart" width="400" height="200"></canvas>
           
        </div>
    </div>

    <!-- Final Notes Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Les Notes Finales</h6>
        </div>
        <div class="card-body">
            <p class="text-gray-800 mb-4">
                Ce tableau de bord vous permet de suivre les performances des utilisateurs sur les quiz. 
                Il inclut leurs scores moyens, le nombre total de tentatives, et des recommandations pour chaque utilisateur.
            </p>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Conseil :</strong> Utilisez les résultats pour identifier les catégories de quiz nécessitant des améliorations.
                </li>
                <li class="list-group-item">
                    <strong>Astuce :</strong> Encouragez les utilisateurs à revoir leurs quiz pour améliorer leur engagement.
                </li>
                <li class="list-group-item">
                    <strong>Statistiques :</strong> Comparez les performances des utilisateurs pour identifier les top performers.
                </li>
            </ul>
        </div>
    </div>

</div>
<!-- End Page Content -->


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pinnacle 2024</span>
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
                    <a class="btn btn-primary" href="html/login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="template/vendor/jquery/jquery.min.js"></script>
    <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="template/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données provenant de PHP
        const chartData = <?php echo $jsonChartData; ?>;

        // Configuration de Chart.js
        const ctx = document.getElementById('quizChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels, // Noms des utilisateurs
                datasets: [
                    {
                        label: 'Scores Moyens',
                        data: chartData.scores,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Score moyen: ' + tooltipItem.raw;
                                }
                            }
                        }
                    },
                    {
                        label: 'Total des Tentatives',
                        data: chartData.attempts,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Total des tentatives: ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Performance des Utilisateurs au Quiz',
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            footer: function(tooltipItems) {
                                return 'Performance globale des utilisateurs';
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Utilisateurs',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Scores / Tentatives',
                        },
                    },
                },
            },
        });

        // Update chart based on user selection
        function updateUserSelection() {
            const userId = document.getElementById('userSelect').value;
            window.location.href = `?user_id=${userId}`;
        }

        // Filter users based on input
        function filterUsers() {
            const filter = document.getElementById('searchFilter').value.toUpperCase();
            const options = document.getElementById('userSelect').options;
            for (let i = 0; i < options.length; i++) {
                let userName = options[i].text.toUpperCase();
                options[i].style.display = userName.includes(filter) ? 'block' : 'none';
            }
        }
        </script>


</body>

</html>