<?php
include_once '../../Controller/QuizController.php';
include_once '../../Model/Quiz.php';

$error = '';
$quiz = null;

// Fetch quiz details directly in this file
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quizId = $_GET['id'];
    $sql = "SELECT * FROM quiz WHERE id = :id";
    $db = config::getConnexion();

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $quizId, PDO::PARAM_INT);
        $stmt->execute();
        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quiz) {
            $error = "Quiz not found.";
        }
    } catch (Exception $e) {
        $error = "Error fetching quiz: " . $e->getMessage();
    }
} else {
    header('Location: listQuiz.php'); // Redirect if no ID is provided
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['title'], $_POST['description'], $_POST['author'], $_POST['creation_date'], $_POST['time_limit'], $_POST['difficulty'], $_POST['category'], $_POST['total_questions']) &&
        !empty($_POST['title']) &&
        !empty($_POST['description']) &&
        !empty($_POST['author']) &&
        !empty($_POST['creation_date']) &&
        !empty($_POST['time_limit']) &&
        !empty($_POST['difficulty']) &&
        !empty($_POST['category']) &&
        !empty($_POST['total_questions'])
    ) {
        try {
            $quizToUpdate = new Quiz(
                $quizId, // ID from the query parameter (doesn't change)
                $_POST['title'], 
                $_POST['description'], 
                new DateTime($_POST['creation_date']), 
                $_POST['author'], 
                (int)$_POST['time_limit'], 
                $_POST['difficulty'], 
                $_POST['category'], 
                (int)$_POST['total_questions'] 
            );

            $quizController = new QuizController();
            $quizController->updateQuiz($quizId, $quizToUpdate); // Pass both the ID and the $Quiz object
            header('Location: listQuiz.php'); // Redirect back to the list of quizzes
            exit;
        } catch (Exception $e) {
            $error = "Error updating quiz: " . $e->getMessage();
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
                        <h1 class="text-primary text-center">Modifier Quiz</h1>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <?php if ($quiz): ?>
                            <!--FORM-->
                            <form action="updateQuiz.php?id=<?= htmlspecialchars($quizId) ?>" method="POST" class="form" onsubmit="return validateForm()">
                                <div class="form-group">
                                    <label for="title" class="text-primary">Titre du Quiz:</label>
                                    <span id="titleError" class="text-danger"></span>
                                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($quiz['title']) ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="description" class="text-primary">Description:</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" ><?= htmlspecialchars($quiz['description']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="creation_date" class="text-primary">Date de Creation:</label>
                                    <span id="descriptionError" class="text-danger"></span>
                                    <input type="date" name="creation_date" id="creation_date" class="form-control" value="<?= htmlspecialchars($quiz['creation_date']) ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="author" class="text-primary">Auteur:</label>
                                    <span id="authorError" class="text-danger"></span>
                                    <input type="text" name="author" id="author" class="form-control" value="<?= htmlspecialchars($quiz['author']) ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="time_limit" class="text-primary">Durée (minutes):</label>
                                    <span id="timeLimitError" class="text-danger"></span>
                                    <input type="number" name="time_limit" id="time_limit" class="form-control" value="<?= htmlspecialchars($quiz['time_limit']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="difficulty" class="text-primary">Difficulté:</label>
                                    <span id="difficultyError" class="text-danger"></span>
                                    <select name="difficulty" id="difficulty" class="form-control" >
                                        <option value="Facile" <?= $quiz['difficulty'] === 'Facile' ? 'selected' : '' ?>>Facile</option>
                                        <option value="Moyenne" <?= $quiz['difficulty'] === 'Moyenne' ? 'selected' : '' ?>>Moyenne</option>
                                        <option value="Difficile" <?= $quiz['difficulty'] === 'Difficile' ? 'selected' : '' ?>>Difficile</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="category" class="text-primary">Catégorie:</label>
                                    <span id="categoryError" class="text-danger"></span>
                                    <select name="category" id="category" class="form-control" >
                                        <option value="BI" <?= $quiz['category'] === 'BI' ? 'selected' : '' ?>>BI</option>
                                        <option value="Cloud" <?= $quiz['category'] === 'Cloud' ? 'selected' : '' ?>>Cloud</option>
                                        <option value="Web Dev" <?= $quiz['category'] === 'Web Dev' ? 'selected' : '' ?>>Web Dev</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total_questions" class="text-primary">Nombre de Questions:</label>
                                    <span id="totalQuestionsError" class="text-danger"></span>
                                    <input type="number" name="total_questions" id="total_questions" class="form-control" value="<?= htmlspecialchars($quiz['total_questions']) ?>" >
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Modifier Quiz</button>
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
        // JavaScript for Form Validation    //form id = quizForm
        function validateForm() {
        let isValid = true; // Tracks overall form validity

        // Reset error messages
        document.getElementById('titleError').textContent = '';
        document.getElementById('descriptionError').textContent = '';
        document.getElementById('authorError').textContent = '';
        document.getElementById('timeLimitError').textContent = '';
        document.getElementById('difficultyError').textContent = '';
        document.getElementById('categoryError').textContent = '';
        document.getElementById('totalQuestionsError').textContent = '';

        // Get input values
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const author = document.getElementById('author').value.trim();
        const timeLimit = document.getElementById('time_limit').value.trim();
        const difficulty = document.getElementById('difficulty').value.trim();
        const category = document.getElementById('category').value.trim();
        const totalQuestions = document.getElementById('total_questions').value.trim();

        // Validate title
        if (!title) {
            document.getElementById('titleError').textContent = 'Le titre est requis.';
            isValid = false;
        }

        // Validate description
        if (!description) {
            document.getElementById('descriptionError').textContent = 'La description est requise.';
            isValid = false;
        }

        // Validate author
        if (!author) {
            document.getElementById('authorError').textContent = 'L\'auteur est requis.';
            isValid = false;
        }

        // Validate time limit (must not be negative)
        if (!timeLimit || timeLimit < 0) {
            document.getElementById('timeLimitError').textContent = 'La durée doit être un nombre positif.';
            isValid = false;
        }

        // Validate difficulty
        if (!difficulty) {
            document.getElementById('difficultyError').textContent = 'La difficulté est requise.';
            isValid = false;
        }

        // Validate category
        if (!category) {
            document.getElementById('categoryError').textContent = 'La catégorie est requise.';
            isValid = false;
        }

        // Validate total questions (must not be negative)
        if (!totalQuestions || totalQuestions < 0) {
            document.getElementById('totalQuestionsError').textContent = 'Le nombre de questions doit être un nombre positif.';
            isValid = false;
        }

        return isValid; // Prevents form submission if any field is invalid
    }


    </script>

</body>

</html>