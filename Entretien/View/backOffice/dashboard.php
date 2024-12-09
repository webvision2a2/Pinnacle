<?php
include '../../Controller/quizController.php';
include '../../Controller/userQuizController.php';

$quizController = new QuizController();
$userQuizController = new UserQuizController();

$quizzes = $quizController->listQuizzes(); // Fetch all quizzes
$userId = 1; // Get user ID from URL parameter if provided
$userQuizzes = $userId ? $userQuizController->listUserQuizzes($userId) : $userQuizController->listQuizzes();

// Prepare data for Chart.js
$quizLabels = [];
$scores = [];
$attempts = [];

foreach ($userQuizzes as $quiz) {
    $quizLabels[] = "Quiz " . $quiz['quiz_id'];
    $scores[] = $quiz['score'];
    $attempts[] = $quiz['attempts'];
}

// Convert data to JSON
$jsonQuizLabels = json_encode($quizLabels);
$jsonScores = json_encode($scores);
$jsonAttempts = json_encode($attempts);
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
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="template\img\LOGO white.png" width="50px" height="50px">
        </div>
        <div class="sidebar-brand-text mx-3">Pinnacle</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
  
<!-- Heading -->
    <div class="sidebar-heading">
        Categories
    </div>

    <!-- Nav Item - Utilisateurs -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user"></i>
            <span>Utilisateurs</span></a>
    </li>

    <!-- Nav Item - Messages -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-envelope"></i>
            <span>Messages</span></a>
    </li>

    <!-- Nav Item - Catalogues -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-book"></i>
            <span>Catalogues</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
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
                <a class="collapse-item" href="listUserQuiz.php">Utilisateur</a>
                <a class="collapse-item" href="listFeedback.php">Feedback</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">detail</h6>
                <a class="collapse-item" href="#">Quiz</a>
                <a class="collapse-item " href="#">Questions</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Ateliers -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-tools"></i>
            <span>Ateliers</span></a>
    </li>

    <!-- Nav Item - Stages -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-briefcase"></i>
            <span>Stages</span></a>
    </li>

    <!-- Nav Item - Evenements -->
                <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-calendar-alt"></i>
            <span>Evenements</span></a>
    </li>

  
        <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    
        <!-- Nav Item - Tables -->
        <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-sign-out-alt"></i>
            <span>Se Déconnecter</span></a>
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
                    <h1>User Quiz Dashboard</h1>
                    <div class="chart-wrapper">
                        <div class="chart-card">
                            <h3 class="chart-title">Quiz Scores</h3>
                            <canvas id="quizScoresChart"></canvas>
                        </div>
                        <div class="chart-card">
                            <h3 class="chart-title">Quiz Attempts</h3>
                            <canvas id="quizAttemptsChart"></canvas>
                        </div>
                        <div class="chart-card">
                            <canvas id="quizChart" width="400" height="200"></canvas>
                        </div>
                   
                        <div class="chart-card">
                            <canvas id="lineChart" width="400" height="200"></canvas>
                        </div>     
                        <div class="chart-card">
                            <canvas id="pieChart" width="400" height="200"></canvas>
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
    <script>
        // Data from PHP
        const quizLabels = <?php echo $jsonQuizLabels; ?>;
        const scores = <?php echo $jsonScores; ?>;
        const attempts = <?php echo $jsonAttempts; ?>;

        // Bar Chart
        const ctxBar = document.getElementById('quizChart').getContext('2d');
        const quizChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: quizLabels,
                datasets: [
                    {
                        label: 'Scores',
                        data: scores,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Attempts',
                        data: attempts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'User Quiz Performance' },
                },
                scales: { y: { beginAtZero: true } },
            },
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: quizLabels,
                datasets: [{
                    data: scores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Quiz Scores Distribution' },
                },
            },
        });

        // Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: quizLabels,
                datasets: [
                    {
                        label: 'Scores',
                        data: scores,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true,
                    },
                    {
                        label: 'Attempts',
                        data: attempts,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Quiz Scores Over Time' },
                },
                scales: { y: { beginAtZero: true } },
            },
        });

        // Chart for Scores
        const scoresCtx = document.getElementById('quizScoresChart').getContext('2d');
        const quizScoresChart = new Chart(scoresCtx, {
            type: 'bar',
            data: {
                labels: quizLabels,
                datasets: [{
                    label: 'Scores',
                    data: scores,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Quiz Scores',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        // Chart for Attempts
        const attemptsCtx = document.getElementById('quizAttemptsChart').getContext('2d');
        const quizAttemptsChart = new Chart(attemptsCtx, {
            type: 'bar',
            data: {
                labels: quizLabels,
                datasets: [{
                    label: 'Attempts',
                    data: attempts,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Quiz Attempts',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

    </script>


</body>

</html>