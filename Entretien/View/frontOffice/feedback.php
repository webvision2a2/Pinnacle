<?php
include '../../Controller/userQuizController.php';
include '../../Controller/feedbackController.php';

// Fetch user and quiz details from session or GET/POST parameters
$userId = $_GET['user_id'];
$quizId = $_GET['quiz_id']; // Assuming the quiz_id is passed as a GET parameter
$currentScore = $_GET['currentScore'];

$userQuizController = new UserQuizController();
$feedbackController = new FeedbackController();

$email = $userQuizController->fetchUserEmail($userId);


$feedbackData = $feedbackController->listFeedback($quizId);
if (!$feedbackData) {
    $feedbackData = [];
}

// Fetch all attempts by the user for the specified quiz
$userAttempts = $userQuizController->listUserQuizzes($userId);
$quizAttempts = array_filter($userAttempts, function ($attempt) use ($quizId) {
    return $attempt['quiz_id'] == $quizId;
});

$totalAttempts = count($quizAttempts);

if ($totalAttempts > 0) {
    $totalScore = array_sum(array_column($quizAttempts, 'score'));
    $averageScore = round($totalScore / $totalAttempts, 2);

    
    $threshold = 5;

    // Generate recommendation based on the current score
    $recommendation = ($currentScore < $threshold)
        ? "Your score is below average. Consider revising this quiz's category to improve!"
        : "Great job! Keep up the good work!";

    // 1. Update the user quiz
    $userQuizController->addUserQuiz((object)[
        'quiz_id' => $quizId,
        'user_id' => $userId,
        'score' => $currentScore,
        'attempts' => $totalAttempts,
        'email' => 'chams.nmiri@gmail.com'
    ]);

    // 2. Generate and add feedback
    $feedbackController->addFeedback((object)[
        'quiz_id' => $quizId,
        'user_id' => $userId,
        'score' => $currentScore,
        'feedback_text' => $recommendation,
        'recommendations' => []  // You can add specific recommendations here if needed
    ]);
} else {

    $totalScore = array_sum(array_column($quizAttempts, 'score'));
    $averageScore = $totalScore;

    
    $threshold = 5;

    // Generate recommendation based on the current score
    $recommendation = ($currentScore < $threshold)
        ? "Your score is below average. Consider revising this quiz's category to improve!"
        : "Great job! Keep up the good work!";

    // 1. Update the user quiz
    $userQuizController->addUserQuiz((object)[
        'quiz_id' => $quizId,
        'user_id' => $userId,
        'score' => $currentScore,
        'attempts' => $totalAttempts,
        'email' => 'chams.nmiri@gmail.com'

    ]);
    $feedbackController->addFeedback((object)[
        'quiz_id' => $quizId,
        'user_id' => $userId,
        'score' => $currentScore,
        'feedback_text' => $recommendation,
        'recommendations' => []  // You can add specific recommendations here if needed
    ]);

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
    <style>
        .container-centered {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensure the container takes full viewport height */
            text-align: center; /* Center the text content */
            padding: 20px; /* Add padding for spacing */
            background-color: var(--light); /* Optional: Apply a background color */
        }

        .feedback-list {
            margin-top: 20px;
            padding: 15px;
            background-color: var(--light);
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-item {
            margin-bottom: 10px;
            font-size: 1rem;
            color: var(--dark);
        }

        .feedback-item em {
            font-style: italic;
            color: var(--secondary);
        }
       .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            margin: 20px 0;
            padding: 0;
            font-family: 'Jost', sans-serif;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            color: var(--dark);
            background-color: var(--light);
            border: 1px solid var(--primary);
            border-radius: 50%;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--primary);
            transform: scale(1.1);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary);
            color: #fff;
            font-weight: 700;
            border-color: var(--secondary);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }

        .pagination .page-link.disabled {
            color: #ccc;
            cursor: not-allowed;
            background-color: var(--light);
            border-color: #ddd;
        }

        .pagination .page-link:first-child,
        .pagination .page-link:last-child {
            border-radius: 50%;
            font-size: 18px;
        }

        .pagination .page-link:first-child:hover,
        .pagination .page-link:last-child:hover {
            transform: translateY(-2px);
        }

        /* Add focus outline for accessibility */
        .pagination .page-link:focus {
            outline: 3px solid var(--secondary);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .pagination .page-link {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
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
        <div class="container-centered">
        <!-- Feedback Section -->
        <h1 class="text-primary fw-bold">Feedback for Your Quiz</h1>
        <p class="fw-medium"><strong>Total Attempts:</strong> <?= $totalAttempts; ?></p>
        <p class="fw-medium"><strong>Current Score:</strong> <?= $currentScore; ?></p>
        <p class="fw-medium"><strong>Average Score:</strong> <?= $averageScore; ?></p>
        <p class="fw-medium"><strong>Feedback:</strong> <?= $recommendation; ?></p>

        <!-- Show previous feedback entries -->
        <h2 class="text-secondary fw-semi-bold">Previous Feedback</h2>
        <div class="feedback-list">
            <?php foreach ($feedbackData as $feedbackItem): ?>
                <p class="feedback-item">
                    <?= htmlspecialchars($feedbackItem['feedback_text']); ?> - 
                    <em><?= implode(', ', json_decode($feedbackItem['recommendations'], true)); ?></em>
                </p>
            <?php endforeach; ?>
        </div>

        <!-- Button to retake quiz -->
        <a href="quiz.php?quiz_id=<?= $quizId; ?>" class="btn btn-primary">Retake Quiz</a>
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