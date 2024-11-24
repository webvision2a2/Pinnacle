<?php
include '../../Controller/questionController.php';

// Fetch the quiz ID from the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_quiz = $_GET['id'];

    // Instantiate the QuestionController to get questions for the quiz
    $quizController = new QuestionController();
    $questions = $quizController->listQuestions($id_quiz);  // Fetch questions for the specific quiz

    // Ensure that there are questions available
    if (empty($questions)) {
        die("Error: Aucune Question Valable Pour Ce Quiz.");
    }

    // Setting the first question as the default question to show
    $currentQuestionId = isset($_GET['question_id']) ? $_GET['question_id'] : $questions[0]['id']; // Show first question by default

    // Find the index of the current question
    $currentQuestionIndex = array_search($currentQuestionId, array_column($questions, 'id'));

} else {
    die("Error: Quiz ID Non Trouvé.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <!-- Favicon -->
    <link href="template/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="template/lib/animate/animate.min.css" rel="stylesheet">
    <link href="template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="template/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="template/css/style.css" rel="stylesheet">

</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" >
               <!-- <span class="sr-only">Loading...</span>  -->
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img class ='logo' src="template/img/LOGO 1 blue.png">
                    <h1 class="m-0">Pinnacle</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#" class="nav-item nav-link">Acceuil</a>
                        <a href="#" class="nav-item nav-link">à Propos</a>
                        <a href="#" class="nav-item nav-link">Evènements</a>
                        <a href="quiz.php" class="nav-item nav-link active">Quiz</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cours</a>
                            <div class="dropdown-menu m-0">
                                <a href="#" class="dropdown-item">Cours (Modules)</a>
                                <a href="#" class="dropdown-item">Videos</a>
                                <a href="#" class="dropdown-item">Ateliers</a>
                            </div>
                        </div>
                        <a href="#" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Commencer</a>
                </div>
            </nav>

        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                   <!--   <h1 class="text-white mb-4 animated slideInDown" >Welcome to the quiz</h1>    -->
                     
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->
    <!-- Quiz Section -->

   
    <div class="container my-5">
        <h1 class="text-center text-primary fw-bold mb-4">Questions pour le Quiz #<?= htmlspecialchars($id_quiz) ?></h1>

        <div class="row justify-content-center">
            <?php if (!empty($questions)) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm rounded p-4">
                        <h5 class="card-title text-secondary"><?= htmlspecialchars($questions[$currentQuestionIndex]['content']) ?></h5>
                        <p class="card-text">
                            <strong>Points:</strong> <?= htmlspecialchars($questions[$currentQuestionIndex]['points']) ?><br>
                            <strong>Type:</strong> <?= htmlspecialchars($questions[$currentQuestionIndex]['type']) ?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="updateQuestion.php?id=<?= htmlspecialchars($questions[$currentQuestionIndex]['id']) ?>&id_quiz=<?= htmlspecialchars($id_quiz) ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="deleteQuestion.php?id=<?= htmlspecialchars($questions[$currentQuestionIndex]['id']) ?>&id_quiz=<?= htmlspecialchars($id_quiz) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?');">Supprimer</a>
                        </div>
                    </div>
                </div>

                <!-- Button to Go to Next Question -->
                <div class="col-12 text-center mt-4">
                    <?php
                    // Get the next question ID if it exists
                    if (isset($questions[$currentQuestionIndex + 1])) {
                        $nextQuestionId = $questions[$currentQuestionIndex + 1]['id'];
                    ?>
                        <a href="question.php?id=<?= htmlspecialchars($id_quiz) ?>&question_id=<?= htmlspecialchars($nextQuestionId) ?>" class="btn btn-primary">Suivant</a>
                    <?php
                    } else {
                        echo "<button class='btn btn-secondary' disabled>Fin du Quiz</button>";
                    }
                    ?>
                </div>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">Aucune question disponible pour ce quiz.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
 
      <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="template/lib/wow/wow.min.js"></script>
    <script src="template/lib/easing/easing.min.js"></script>
    <script src="template/lib/waypoints/waypoints.min.js"></script>
    <script src="template/lib/counterup/counterup.min.js"></script>
    <script src="template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="template/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="template/lib/lightbox/js/lightbox.min.js"></script>
    
    <script src="template/js/main.js"></script>
    
</body>
</html>