<?php
include_once '../../Controller/UserQuizController.php';


$error = '';
$userQuiz = null;

// Fetch user quiz details directly in this file
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userQuizId = $_GET['id'];
    $sql = "SELECT * FROM user_quiz WHERE id = :id";
    $db = config::getConnexion();

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userQuizId, PDO::PARAM_INT);
        $stmt->execute();
        $userQuiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userQuiz) {
            $error = "User quiz not found.";
        }
    } catch (Exception $e) {
        $error = "Error fetching user quiz: " . $e->getMessage();
    }
} else {
    header('Location: listUserQuiz.php'); // Redirect if no ID is provided
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['quiz_id'], $_POST['user_id'], $_POST['score'], $_POST['attempts'], $_POST['email']) &&
        !empty($_POST['quiz_id']) &&
        !empty($_POST['user_id']) &&
        !empty($_POST['score']) &&
        !empty($_POST['attempts']) &&
        !empty($_POST['email'])
    ) {
        try {
            $userQuizToUpdate = new UserQuiz(
                $userQuizId, // ID from the query parameter (doesn't change)
                $_POST['quiz_id'],
                $_POST['user_id'],
                $_POST['score'],
                $_POST['attempts'],
                $_POST['email']
            );

            $userQuizController = new UserQuizController();
            $userQuizController->updateUserQuiz($userQuizId, $userQuizToUpdate); // Pass both the ID and the $UserQuiz object
            header('Location: listUserQuiz.php'); // Redirect back to the list of user quizzes
            exit;
        } catch (Exception $e) {
            $error = "Error updating user quiz: " . $e->getMessage();
        }
    } else {
        $error = "All fields are required.";
    }
}
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
                <a class="nav-link" href="#">
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
                <a class="collapse-item" href="listUserQuiz.php">Utilisateurs</a>
                <a class="collapse-item" href="listFeedback.php">Feedbacks</a>
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
                    <div class="container mt-5">
                    <h1 class="text-primary text-center">Modifier Quiz Utilisateur</h1>

                    <?php if ($userQuiz): ?>
                        <!--FORM-->
                        <form action="updateUserQuiz.php?id=<?= htmlspecialchars($userQuizId) ?>" method="POST" class="form" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="quiz_id" class="text-primary">ID du Quiz:</label>
                                <span id="quizIdError" class="text-danger"></span>
                                <input type="text" name="quiz_id" id="quiz_id" class="form-control" value="<?= htmlspecialchars($userQuiz['quiz_id']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="text-primary">ID Utilisateur:</label>
                                <span id="userIdError" class="text-danger"></span>
                                <input type="text" name="user_id" id="user_id" class="form-control" value="<?= htmlspecialchars($userQuiz['user_id']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="score" class="text-primary">Score:</label>
                                <span id="scoreError" class="text-danger"></span>
                                <input type="text" name="score" id="score" class="form-control" value="<?= htmlspecialchars($userQuiz['score']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="attempts" class="text-primary">Tentatives:</label>
                                <span id="attemptsError" class="text-danger"></span>
                                <input type="text" name="attempts" id="attempts" class="form-control" value="<?= htmlspecialchars($userQuiz['attempts']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-primary">E-mail:</label>
                                <span id="emailError" class="text-danger"></span>
                                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($userQuiz['email']) ?>">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Modifier Quiz Utilisateur</button>
                        </form>
                    <?php endif; ?>
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
    <script>
    // JavaScript for Form Validation
    function validateForm() {
        let isValid = true; // Tracks overall form validity

        // Reset error messages
        document.getElementById('quizIdError').textContent = '';
        document.getElementById('userIdError').textContent = '';
        document.getElementById('scoreError').textContent = '';
        document.getElementById('attemptsError').textContent = '';
        document.getElementById('emailError').textContent = '';

        // Get input values
        const quizId = document.getElementById('quiz_id').value.trim();
        const userId = document.getElementById('user_id').value.trim();
        const score = document.getElementById('score').value.trim();
        const attempts = document.getElementById('attempts').value.trim();
        const email = document.getElementById('email').value.trim();

        // Validate quiz ID
        if (!quizId) {
            document.getElementById('quizIdError').textContent = 'L\'ID du quiz est requis.';
            isValid = false;
        }

        // Validate user ID
        if (!userId) {
            document.getElementById('userIdError').textContent = 'L\'ID de l\'utilisateur est requis.';
            isValid = false;
        }

        // Validate score (must be a valid number)
        if (!score || isNaN(score)) {
            document.getElementById('scoreError').textContent = 'Le score doit être un nombre valide.';
            isValid = false;
        }

        // Validate attempts (must be a valid number)
        if (!attempts || isNaN(attempts)) {
            document.getElementById('attemptsError').textContent = 'Les tentatives doivent être un nombre valide.';
            isValid = false;
        }

        // Validate email
        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            document.getElementById('emailError').textContent = 'Veuillez entrer une adresse e-mail valide.';
            isValid = false;
        }

        return isValid; // Prevents form submission if any field is invalid
    }
    </script>

</body>

</html>