<?php
include '../../Controller/questionController.php';
include '../../Controller/quizController.php';
include '../../Controller/reponseController.php';

session_start();

// Check if quiz ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_quiz = $_GET['id'];

    // Instantiate controllers
    $reponseController = new ReponseController();
    $quizController = new QuestionController();
    $quizController1 = new QuizController();

    // Fetch quiz questions
    $questions = $quizController->listQuestions($id_quiz);  
    if (empty($questions)) {
        die("Error: Aucune Question Valable Pour Ce Quiz.");
    }

    // Fetch quiz details (e.g., time limit)
    $quizDetails = $quizController1->showQuiz($id_quiz); 
    if (!$quizDetails) {
        die("Error: Détails du Quiz (temps) Introuvables.");
    }

    // Set time limit from quiz details
    $timeLimit = $quizDetails['time_limit']; // Assuming this is in minutes

    // Set the current question ID
    $currentQuestionId = isset($_GET['question_id']) ? $_GET['question_id'] : $questions[0]['id']; 

    // Find the current question index
    $currentQuestionIndex = array_search($currentQuestionId, array_column($questions, 'id'));

    // Check if the current question index is valid
    if ($currentQuestionIndex === false) {
        die("Error: Question non trouvée.");
    }

    // Access the current question
    $currentQuestion = $questions[$currentQuestionIndex]; 

    // Fetch answers for the current question
    $answers = $reponseController->listReponses($currentQuestionId);

    $question = $quizController->showQuestion($currentQuestionId);

    // Access the 'type' field of the current question dynamically
    $questionType = $currentQuestion['type'];
    error_log("Question ID: " . $currentQuestion['id'] . " | Type: " . $questionType);


    // Identify the correct answer (where 'is_correct' = 1)
    $correctAnswer = null;
    foreach ($answers as $answer) {
        if ($answer['is_correct'] == 1) {
            $correctAnswer = $answer['content'];  // Get the correct answer content
            break;  // Exit once the correct answer is found
        }
    }

    // Check if it's a short-answer question
    $isShortAnswer = $currentQuestion['type'] == 'Réponse Courte';

    // Handle score tracking, etc.
    $currentScore = isset($_GET['score']) ? intval($_GET['score']) : 0; // Track score from GET
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

    <style>
        .timer {
        font-size: 28px;
        font-weight: bold;
        color: #e74c3c; /* Red color for better visibility */
        text-align: center;
        margin-bottom: 30px;
        background-color: #f7f7f7; /* Light background */
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for better contrast */
        width: 200px;
        margin: 0 auto;
        }
        .answers {
            display: flex;
            flex-direction: column; /* Align buttons vertically */
            align-items: center; /* Center the buttons horizontally */
            justify-content: center; /* Center the buttons vertically (optional) */
            gap: 10px; /* Add space between the buttons */
        }

        .answer-btn {
            width: 100%;
            max-width: 400px; /* Ensure consistent width for buttons */
            padding: 15px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin: 0 auto; /* Ensure centered alignment */
        }


        .answers .answer-btn:hover {
            background-color: var(--primary);
            color: var(--light);
            transform: translateY(-3px);
        }

        .answers .answer-btn.selected {
            background-color: var(--secondary);
            color: var(--light);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        .answer-btn.correct {
            background-color: #28a745 !important; /* Green for correct */
            color: white;
        }

        .answer-btn.incorrect {
            background-color: #dc3545 !important; /* Red for incorrect */
            color: white;
        }

        .answer-btn:disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        .card-header {
            font-size: 1rem;
            font-weight: bold;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid #dee2e6;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-footer {
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .text-primary {
            color: #0056b3 !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .answers button {
            width: 100%;
            margin-bottom: 0.5rem;
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
                            <a href="profile.php" class="nav-link text-white">Profil</a>
                        </li>
                    </ul>

                    <!-- User Greeting and Logout Button -->

                    <a href="../logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
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

        <!-- Timer and Progress Bar -->
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <div class="timer" id="timer" style="font-size: 18px; font-weight: bold; color: red;">
                    Temps restant: <span id="timeDisplay"><?= htmlspecialchars($timeLimit) ?>:00</span>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <!-- Progress Bar -->
                <div class="progress" style="height: 10px; width: 35%; border-radius: 5px;">
                    <div id="progressBar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <?php if (!empty($questions)) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm rounded p-4">
                        <!-- Card Header with Progress and Points -->
                        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom">
                            <span class="text-primary"><strong>Question <?= $currentQuestionIndex + 1 ?> of <?= count($questions) ?></strong></span>
                            <span class="badge bg-info text-dark">Points: <?= htmlspecialchars($questions[$currentQuestionIndex]['points']) ?></span>
                        </div>
                        
                        <!-- Question Content -->
                        <div class="card-body">
                            <h5 class="card-title text-secondary"><?= htmlspecialchars($questions[$currentQuestionIndex]['content']) ?></h5>

                            <!-- Display answers -->
                            <?php if ($isShortAnswer): ?>
                                <div class="form-group">
                                    <label for="short_answer" class="text-primary">Votre réponse :</label>
                                    <input type="text" class="form-control" id="short_answer" placeholder="Entrez votre réponse ici">
                                </div>
                            <?php else: ?>
                                <div id="selectedAnswerContainer" class="answers mt-3">
                                    <h6 class="text-primary">Réponses possibles:</h6>
                                    <?php foreach ($answers as $index => $answer): ?>
                                        <button 
                                            class="btn btn-outline-primary answer-btn mb-2" 
                                            onclick="handleAnswerClick(this)" 
                                            data-value="<?= $answer['id'] ?>" 
                                            data-correct="<?= $answer['is_correct'] ?>" 
                                            id="answer_<?= $index ?>">
                                            <?= htmlspecialchars($answer['content']) ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Footer with Current Score -->
                        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                            <strong class="text-secondary">Score Actuel:</strong>
                            <span id="currentScoreDisplay" class="badge bg-success"><?= htmlspecialchars($currentScore) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Button to Go to Next Question -->
                <div class="col-12 text-center mt-4">
                    <?php if (isset($questions[$currentQuestionIndex + 1])): ?>
                        <button id="nextBtn" class="btn btn-primary">Suivant</button>
                    <?php else: ?>
                        <button id="submitbtn" class="btn btn-success">Fin du Quiz</button>
                    <?php endif; ?>
                </div>
            <?php else: ?>
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
    

    <script>
        // Initialize variables for the timer, current question index, and total questions
        let timeLimit = <?= isset($_GET['remaining_time']) ? $_GET['remaining_time'] : ($timeLimit * 60) ?>;
        let idquiz =<?= $id_quiz ?>;
        var iduser= <?php echo json_encode($_SESSION['id']); ?>;
        /* let iduser =<?= $_SESSION['id'] ?>; */
        let currentQuestionIndex = <?= $currentQuestionIndex ?>;
        let totalQuestions = <?= count($questions) ?>;
        let questions = <?= json_encode($questions) ?>;
        let answers = <?= json_encode($answers) ?>;
        let currentScore = <?= $currentScore ?>;
        let selectedAnswer = null; // Store the selected answer globally

        // Update the timer display and progress bar
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLimit / 60);
            const seconds = timeLimit % 60;
            document.getElementById('timeDisplay').textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            const percentage = (timeLimit / (<?= $timeLimit ?> * 60)) * 100;
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);

            progressBar.className = `progress-bar progress-bar-striped ${
                percentage > 75 ? 'bg-success' : percentage > 50 ? 'bg-warning' : 'bg-danger'
            }`;
        }

        // Start the timer
        function startTimer() {
            const interval = setInterval(() => {
                if (timeLimit > 0) {
                    timeLimit--;
                    updateTimerDisplay();
                } else {
                    clearInterval(interval);
                    alert("Temps écoulé ! Le quiz est terminé.");
                    window.location.href = 'quiz.php'; // Redirect to quizzes list
                }
            }, 1000);
        }

        // Handle answer button click
        function handleAnswerClick(button) {
            document.querySelectorAll(".answer-btn").forEach(btn => {
                btn.classList.remove("btn-secondary", "selected");
                btn.classList.add("btn-primary");
            });

            button.classList.add("btn-secondary", "selected");
            selectedAnswer = button; // Save the selected answer for later evaluation
        }

       // Function to load the next question via AJAX
        function loadNextQuestion() {
            // Check if it's a short-answer question, ensure an answer is provided
            if (document.getElementById('short_answer') && !document.getElementById('short_answer').value.trim()) {
                alert('Veuillez entrer une réponse avant de passer à la question suivante.');
                return;
            }

            // If it's a multiple-choice question, check if an answer was selected
            if (!selectedAnswer && !document.getElementById('short_answer')) {
                alert('Veuillez sélectionner une réponse avant de passer à la question suivante.');
                return;
            }

            // If a multiple-choice answer is selected, handle answer validation and update score
            if (selectedAnswer) {
                const isCorrect = selectedAnswer.dataset.correct === "1";
                selectedAnswer.classList.remove("btn-secondary", "btn-primary");
                selectedAnswer.classList.add(isCorrect ? "correct" : "incorrect");

                // Update score if the answer is correct
                if (isCorrect) {
                    currentScore += parseInt(questions[currentQuestionIndex].points);
                }
            }

            // Load the next question
            if (currentQuestionIndex < totalQuestions - 1) {
                currentQuestionIndex++;

                // Update progress header with the new question number and total
                document.querySelector('.card-header span.text-primary').textContent = `Question ${currentQuestionIndex + 1} of ${totalQuestions}`;
                const nextQuestionId = <?= json_encode(array_column($questions, 'id')) ?>[currentQuestionIndex];

                // Update the points badge with the new question's points
                document.querySelector('.card-header .badge').textContent = `Points: ${questions[currentQuestionIndex].points}`;

                // Delay to show feedback before moving to the next question
                setTimeout(() => {
                    fetch(`question.php?id=<?= htmlspecialchars($id_quiz) ?>&question_id=${nextQuestionId}&remaining_time=${timeLimit}`)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Update the question title
                            document.querySelector('.card-title').textContent = doc.querySelector('.card-title').textContent;

                            // Clear previous answers and load new ones
                            const answerContainer = document.querySelector('.answers');
                            answerContainer.innerHTML = ''; // Clear old answers
                            answerContainer.innerHTML = doc.querySelector('.answers').innerHTML; // Load new answers

                            // Reattach event handlers for dynamically loaded buttons
                            document.querySelectorAll('.answer-btn').forEach(button => {
                                button.onclick = function () {
                                    handleAnswerClick(this);
                                };
                            });

                            // Update the current score display
                            document.getElementById('currentScoreDisplay').textContent = currentScore;

                            // Clear selected answer for the next question
                            selectedAnswer = null;
                            const shortAnswerInput = document.getElementById('short_answer');
                            if (shortAnswerInput) shortAnswerInput.value = ''; // Clear the short-answer field if applicable

                            // Check question type and show/hide short-answer input
                            const newQuestionType = doc.querySelector('#questionType').textContent.trim();
                            if (newQuestionType === 'Réponse Courte') {
                                shortAnswerInput.style.display = 'block'; // Show the short-answer input
                            } else {
                                shortAnswerInput.style.display = 'none'; // Hide the short-answer input
                            }
                        })
                        .catch(error => console.error('Error loading the next question:', error));
                }, 1000); // Delay of 1 second before moving to the next question
            } else {
                // If it's the last question, show the final feedback
                setTimeout(() => {
                    alert(`Fin du quiz. Votre score final est : ${currentScore}`);
                    window.location.href = `feedback.php?quiz_id=${idquiz}&user_id=${iduser}&currentScore=${currentScore}`;
                }, 1000); // Show feedback for 1 second before showing the final score alert
            }
        }


        // Start the timer on page load
        startTimer();

        // Next Button Click Handler
        document.getElementById('nextBtn').addEventListener('click', loadNextQuestion);
        document.getElementById('submitbtn').addEvent('click', window.location.href = 'feedback.php');

    </script>



    
</body>
</html>