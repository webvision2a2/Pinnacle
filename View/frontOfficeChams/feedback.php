<?php
include(__DIR__ . '/../../Controller/userQuizController.php');
include(__DIR__ . '/../../Controller/feedbackController.php');
include(__DIR__ . '/../../Controller/quizController.php');


// YouTube API key
$apiKey = "AIzaSyA-T2j9XwHiuIqduCf8fJlxXqG57G9QmuM";

// Fetch user and quiz details
$userId = $_GET['user_id'] ?? null;
$quizId = $_GET['quiz_id'] ?? null;
$currentScore = $_GET['currentScore'] ?? null;

// Validate required parameters
if (!$userId || !$quizId || !$currentScore) {
    die("Erreur : Paramètres 'user_id', 'quiz_id' ou 'currentScore' manquants.");
}

// Initialize controllers
$userQuizController = new UserQuizController();
$feedbackController = new FeedbackController();
$userController = new UserController();
$quizController = new QuizController();

// Fetch quiz category
$category = $quizController->fetchCategoryByQuizId($quizId);
if (!$category) {
    die("Erreur : Catégorie introuvable pour ce quiz.");
}

// Fetch user details
$email = $userController->fetchEmailByUserId($userId);
$name = $userController->fetchNameByUserId($userId);
if (!$email || !$name) {
    die("Erreur : Informations utilisateur invalides.");
}

// Fetch previous attempts
$userAttempts = $userQuizController->listUserQuizzes($userId);
$quizAttempts = array_filter($userAttempts, fn($attempt) => $attempt['quiz_id'] == $quizId);

$totalAttempts = count($quizAttempts);
$totalScore = array_sum(array_column($quizAttempts, 'score'));
$averageScore = $totalAttempts ? round($totalScore / $totalAttempts, 2) : 0;

$threshold = 5; // Example threshold for recommendation

// Generate recommendation
$recommendation = $currentScore < $threshold
    ? "Votre score est inférieur à la moyenne. Revoyez cette catégorie pour vous améliorer !" 
    : "Félicitations ! Continuez comme ça !";

// Update user quiz
$userQuizController->addUserQuiz((object)[
    'quiz_id' => $quizId,
    'user_id' => $userId,
    'score' => $currentScore,
    'attempts' => $totalAttempts,
    'email' => $email
]);

// Add feedback
$feedbackController->addFeedback((object)[
    'quiz_id' => $quizId,
    'user_id' => $userId,
    'score' => $currentScore,
    'feedback_text' => $recommendation,
    'recommendations' => []
]);

// Fetch YouTube recommendations
function getYouTubeRecommendations($apiKey, $category, $maxResults = 5) {
    $categoryEncoded = urlencode($category);
    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=$maxResults&q=$categoryEncoded&type=video&key=$apiKey";

    $response = @file_get_contents($url);
    if ($response === FALSE) {
        return [];
    }

    $data = json_decode($response, true);
    return array_map(
        fn($item) => [
            'title' => $item['snippet']['title'],
            'url' => "https://www.youtube.com/watch?v=" . $item['id']['videoId']
        ],
        $data['items']
    );
}

// Get recommendations dynamically
$videoRecommendations = getYouTubeRecommendations($apiKey, $category);

$recommendations = array_map(
    fn($video) => "{$video['title']} - {$video['url']}",
    $videoRecommendations
);

// Send feedback email
$feedbackController->sendFeedbackEmail(
    $email,
    $name,
    $quizId,
    $currentScore,
    $recommendation,
    $recommendations
);
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
    <style>
        body {
            background-color: #ffffff; /* Set the entire page background to white */
            font-family: 'Heebo', sans-serif;
        }

        .container-centered {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensure the container takes full viewport height */
            text-align: center; /* Center the text content */
            padding: 20px; /* Add padding for spacing */
            background-color: #ffffff; /* White background for the container */
        }

        .feedback-list {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9; /* Light grey background for feedback section */
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-item {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #333333; /* Dark text color for contrast */
        }

        .feedback-item em {
            font-style: italic;
            color: #007bff; /* Use primary color for emphasis */
        }

        .btn {
            margin-top: 20px;
        }
    </style>

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
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto py-0">
                        <li class="nav-item">
                            <a href="../frontOffice_zeineb/Template/index.php" class="nav-link text-white">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontoff/catalogue.php" class="nav-link text-white">Catalogue</a>
                        </li>
                        <li class="nav-item">
                            <a href="quiz.php" class="nav-link text-white active">Entretien</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontofficeahmed/main.php" class="nav-link text-white">Sociétés</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontofficeahmed/main2.php" class="nav-link text-white">Stages</a>
                        </li>
                        <li class="nav-item">
                            <a href="../frontoffice moemen/topicsPage.php" class="nav-link text-white">Psychologie</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                                Événement <span class="arrow">&#9660;</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../FrontOffice/eventdispo.php" class="dropdown-item">Nos événements</a>
                                </li>
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#addEventModal">Ajouter un événement</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../frontOffice_zeineb/Template/profile.php" class="nav-link text-white">Profil</a>
                        </li>
                    </ul>

                    <!-- User Greeting and Logout Button -->

                    <a href="../frontOffice_zeineb/logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
                </div>
            </nav>

        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                   <!--   <h1 class="text-white mb-4 animated slideInDown" >Welcome to the quiz</h1>    -->
                     
                    
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="container-centered">
            <h1 class="text-primary fw-bold">Résumé du Quiz</h1>
            <p class="fw-medium"><strong>Total des essais :</strong> <?= $totalAttempts; ?></p>
            <p class="fw-medium"><strong>Score actuel :</strong> <?= $currentScore; ?></p>
            <p class="fw-medium"><strong>Score moyen :</strong> <?= $averageScore; ?></p>
            <p class="fw-medium"><strong>Commentaire :</strong> <?= $recommendation; ?></p>

            <!-- Display thank you message -->
            <p class="fw-medium text-success">Un e-mail vous a été envoyé avec votre score et des informations sur ce quiz. Merci d'avoir participé au quiz d'entretien !</p>

            <!-- Button to go back to quizzes -->
            <a href="quiz.php?quiz_id=<?= $quizId; ?>" class="btn btn-primary">Revenir aux Quiz</a>
        </div>
</body>
        </ul>
    </nav>
 
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