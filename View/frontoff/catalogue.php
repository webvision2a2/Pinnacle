<?php
// catalogue.php
include_once '../../Model/Domaine.php';
include_once '../../Model/Cours.php';
include_once '../../Controller/CRUD.php';
include_once '../../Model/Rating.php';
include_once '../../config_zeineb.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize pagination variables
$itemsPerPage = 4;
$currentDomainePage = isset($_GET['domaine_page']) ? (int) $_GET['domaine_page'] : 1;

// Fetch all domaines with pagination
$domaines = readDomaines($currentDomainePage, $itemsPerPage);

// Calculate total pages
$totalDomaines = getTotalDomaines();
$totalDomainePages = ceil($totalDomaines / $itemsPerPage);

// Initialize variable for selected domain ID
$domaine_id = isset($_GET['domaine_id']) ? intval($_GET['domaine_id']) : 0;

// Initialize variable for course search
$search_query = isset($_POST['search']) ? trim($_POST['search']) : '';

// Fetch courses based on selected domaine ID if provided
$coursByDomaine = $domaine_id > 0 ? getCoursByDomaineId($domaine_id) : [];

// If a search query is provided, filter courses
$coursBySearch = !empty($search_query) ? searchCours($search_query) : [];

// Combine results: prioritize search results over domain results
$cours = !empty($coursBySearch) ? $coursBySearch : $coursByDomaine;

?>

<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="utf-8">
    <title>Catalogue - Digital Agency</title>
    <meta content="width=device-width, initial-scale=1.0" nom="viewport">

    <!-- CSS Links -->
    <link href="../../Templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../Templates/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Make sure FontAwesome is included -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        .star {
            cursor: pointer;
            font-size: 24px;
            color: #FFD700;
        }

        /* Theme Variables */
        :root[data-theme="light"] {
            --bg-color: #f8f9fa;
            --text-color: #555;
            --card-bg: #ffffff;
            --navbar-bg: #2C24CE;
            --card-border: #007bff;
            --heading-color: #2C24CE;
            --input-bg: #ffffff;
            --input-text: #555;
        }

        :root[data-theme="dark"] {
            --bg-color: #1a1a1a;
            --text-color: #e0e0e0;
            --card-bg: #2d2d2d;
            --navbar-bg: #1a1a2e;
            --card-border: #4a4a4a;
            --heading-color: #7b7bff;
            --input-bg: #333;
            --input-text: #fff;
        }

        /* Apply theme to elements */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .navbar {
            background-color: var(--navbar-bg) !important;
        }

        .domaine-card {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-color) !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--heading-color);
        }

        .form-control {
            background-color: var(--input-bg);
            color: var(--input-text);
            border-color: var(--card-border);
        }

        .form-control::placeholder {
            color: var(--text-color);
            opacity: 0.7;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background-color: var(--card-bg);
            color: var(--text-color);
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        .navbar {
            background-color: #2C24CE;
            width: 100%;
            /* Ensure navbar is full width */
        }

        .navbar-brand img {
            max-height: 40px;
        }

        .domaine-card {
            background: #ffffff;
            /* White background for cards */
            border: 2px solid #007bff;
            /* Blue border */
            border-radius: 12px;
            /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Smooth transitions */
            padding: 20px;
            /* Padding inside the card */
            margin-bottom: 20px;
            /* Space between cards */
            text-align: center;
            /* Centered text */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto;
            /* Allow height to adjust based on content */
        }

        .domaine-card:hover {
            transform: translateY(-5px);
            /* Lift effect on hover */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            /* Enhanced shadow on hover */
        }

        .domaine-card img {
            width: 100%;
            /* Responsive image */
            height: auto;
            /* Maintain aspect ratio */
            max-height: 160px;
            /* Limit height for uniformity */
            object-fit: cover;
            /* Crop image to fit without stretching */
            border-radius: 10px;
            /* Rounded corners for images */
        }

        .domaine-card h4 {
            margin-top: 15px;
            color: #007bff;
            /* Brand color for titles */
            font-size: 1.6rem;
            /* Larger title font size */
        }

        .domaine-card p {
            margin-top: 10px;
            margin-bottom auto;
            color: #555;
            /* Dark gray text for descriptions */
            font-size: 1rem;
            /* Standard description font size */
        }

        .btn-cours {
            background: linear-gradient(45deg, #007bff, #0056b3);
            /* Blue gradient */
            color: white;
            border-radius: 25px;
            /* Rounded corners */
            padding: 10px 20px;
            /* Comfortable padding */
            font-size: 1rem;
            /* Font size */
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
            /* Smooth transitions */
        }

        .btn-cours:hover {
            background: linear-gradient(45deg, #0056b3, #003d80);
            /* Darker gradient on hover */
            transform: translateY(-2px);
            /* Slight lift effect on hover */
        }

        h1 {
            color: #2C24CE;
            margin-bottom: 30px;
        }

        .footer {
            background-color: #2C24CE;
            /* Same color as cards */
            color: white;
            /* White text for contrast */
            padding: 30px 0;
            text-align: center;
        }

        .speak-button {
            background: linear-gradient(45deg, #2C24CE, #4A43E2);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(44, 36, 206, 0.2);
        }

        .speak-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(44, 36, 206, 0.3);
            background: linear-gradient(45deg, #241CB0, #2C24CE);
        }

        .speak-button:active {
            transform: translateY(1px);
        }

        .speak-button i {
            font-size: 1.1rem;
        }

        /* Style pour l'état actif (pendant la lecture) */
        .speak-button.speaking {
            background: linear-gradient(45deg, #FF4B4B, #FF6B6B);
            animation: pulse 2s infinite;
        }

        .share-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            justify-content: center;
        }

        .share-button {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .share-button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .share-button.facebook {
            background-color: #3b5998;
        }

        .share-button.twitter {
            background-color: #1da1f2;
        }

        .share-button.linkedin {
            background-color: #0077b5;
        }

        .share-button i {
            font-size: 1.2rem;
        }

        .advanced-search-container {
            position: relative;
            max-width: 600px;
            margin: 20px auto;
        }

        .search-box {
            position: relative;
        }

        .btn-voice {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #2C24CE;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-voice:hover {
            background: #1f1b9e;
        }

        .btn-voice.listening {
            background: #ff4444;
            animation: pulse 1.5s infinite;
        }

        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #2C24CE;
            opacity: 0;
            pointer-events: none;
        }

        .listening .pulse-ring {
            animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .voice-feedback {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-top: 10px;
            display: none;
            z-index: 100;
        }

        .voice-feedback.active {
            display: block;
        }

        .voice-status {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .voice-text {
            color: #666;
            margin-bottom: 15px;
        }

        .voice-commands {
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .voice-commands ul {
            list-style: none;
            padding: 0;
            margin: 5px 0 0;
        }

        .voice-commands li {
            color: #666;
            font-size: 0.9em;
            margin: 5px 0;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .search-results.active {
            display: block;
        }

        .btn-purple {
            background: linear-gradient(45deg, #8e44ad, #9b59b6);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-purple:hover {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: translate(-50%, -50%) scale(0.7);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2C24CE;">
        <div class="container-fluid">
            <a href="" class="navbar-brand p-0">
                <img class='logo' src="img/LOGO 1 blue.png" alt="Logo" style="max-height: 40px;">
                <h1 class="m-0" style="color: white;">Pinnacle</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars" style="color: white;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="../frontOffice_zeineb/Template/index.php" class="nav-item nav-link"
                        style="color: white;">Accueil</a>
                    <a href="catalogue.php" class="nav-item nav-link" style="color: white;">Catalogue</a>
                    <a href="../frontOfficeChams/quiz.php" class="nav-link text-white">Entretien</a>
                    <a href="../../frontofficeahmed/main.php" class="nav-item nav-link">Societes</a>
                        <a href="../../frontofficeahmed/main2.php" class="nav-item nav-link text-white">Stages</a>
                        <a href="../frontoffice moemen/topicsPage.php" class="nav-item nav-link text-white">Psychologie</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Evenement<span
                                    class="arrow">&#9660;</span></a>
                            <div class="dropdown-menu">
                                <a href="../../FrontOffice/eventdispo.php" class="dropdown-item">Nos événements</a>
                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#addEventModal">Ajouter un événement</a>
                            </div>
                        </div>
                    <a href="../frontOffice_zeineb/Template/profile.php" class="nav-item nav-link text-white">Profil</a>
                    <div class="navbar-nav">
                        <button id="speakButton" class="nav-item nav-link btn btn-link" style="color: white;">
                            <i class="fas fa-volume-up"></i> Lire à voix haute
                        </button>
                    </div>
                    <a href="../frontOffice_zeineb/logout.php" class="btn btn-warning rounded-pill py-2 px-4">Se Déconnecter</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Catalogue Content Start -->
    <div class='container py-5'>
        <h1 class='text-center'>Les domaines disponibles</h1>

        <!-- Domain Selection Form -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <select name="domaine_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Sélectionner un domaine</option>
                    <?php foreach ($domaines as $domaine): ?>
                        <option value="<?php echo htmlspecialchars($domaine['id']); ?>" <?php echo ($domaine_id == $domaine['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($domaine['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-primary" type="submit">Afficher Cours</button>
            </div>
        </form>
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" id="searchInput" class="form-control"
                    placeholder="Rechercher un cours..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
                <button class="btn btn-voice" id="voiceSearchBtn" type="button">
                    <i class="fas fa-microphone"></i>
                    <span class="pulse-ring"></span>
                </button>
            </div>
            <div id="voiceFeedback" class="voice-feedback">
                <div class="voice-status"></div>
                <div class="voice-text"></div>
            </div>
        </form>

        <!-- Display Courses for Selected Domain or Search Results -->
        <?php if ($domaine_id > 0): ?>
            <h2 class='text-center'>Cours pour le domaine
                "<?php echo htmlspecialchars(getDomaineById($domaine_id)['nom']); ?>"</h2>
        <?php endif; ?>

        <!-- Course Results Section -->
        <div class='row justify-content-around mt-4'>
            <?php if (!empty($cours)): ?>
                <?php foreach ($cours as $course): ?>
                    <div class='col-md-4 mb-4'>
                        <!-- Course Card -->
                        <div class='domaine-card shadow-sm p-4 rounded text-center'>
                            <h5><?php echo htmlspecialchars($course['nom']); ?></h5>
                            <a class='btn-cours' href="<?php echo htmlspecialchars($course['fichier']); ?>"
                                target="_blank">Télécharger le cours</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Message when no courses are found -->
                <?php if (!empty($search_query)): ?>
                    <p>Aucun cours trouvé pour votre recherche.</p>
                <?php else: ?>
                    <p>Aucun cours trouvé pour ce domaine.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class='text-center mb-4'>
            <div class="d-flex justify-content-center gap-3">
                <a href='flashcards.php' class='btn btn-success'>
                    <i class="fas fa-brain"></i> Learning git
                </a>
                <a href='games/motivation.php' class='btn btn-purple'>
                    <i class="fas fa-edit"></i>motivation
                </a>
                <a href='games/eyagame.php' class='btn btn-info'>
                    <i class="fas fa-edit"></i>motivation
                </a>
                <a href='games/memory.php' class='btn btn-warning'>
                    <i class="fas fa-key"></i> Security Guardian
                </a>
                <a href='games/jeu.php' class='btn btn-danger'>
                    <i class="fas fa-spa"></i> super pinnacle
                </a>
            </div>
        </div>

        <!-- Display Domain Cards -->
        <div class='row justify-content-around mt-4'>
            <?php if (!empty($domaines)): ?>
                <?php foreach ($domaines as $domaine): ?>
                    <div class='col-md-4 mb-4'>
                        <!-- Domain Card -->
                        <div class='domaine-card shadow-sm p-4 rounded text-center'>
                            <?php if (!empty($domaine['image'])): ?>
                                <!-- Display image if available -->
                                <img src="<?php echo htmlspecialchars($domaine['image']); ?>"
                                    alt="<?php echo htmlspecialchars($domaine['nom']); ?>" />
                            <?php else: ?>
                                <p>Aucune image disponible</p>
                            <?php endif; ?>
                            <h4><?php echo htmlspecialchars($domaine['nom']); ?></h4>
                            <h5><?php echo htmlspecialchars($domaine['description']); ?></h5>
                            <h4><?php echo htmlspecialchars($domaine['competence']); ?></h4>
                            <h6> Rating
                                <?php
                                $RatingModel = new Rating();
                                $avgRating = $RatingModel->getAverageRating($domaine['id']);
                                for ($i = 0; $i < $avgRating; $i++) { ?>
                                    <span class='star'>&#9733;</span>
                                <?php } ?>
                            </h6>
                            <!-- Button to view course -->
                            <a class='btn-cours' href="listecours.php?domaine_id=<?php echo $domaine['id']; ?>">Voir Cours</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun domaine disponible.</p>
            <?php endif; ?>
        </div>


    </div>
    <!-- Share Buttons -->
    <div class="container">
        <h4 class="text-center mb-3">Partager ce catalogue</h4>
        <div class="share-buttons">
            <button class="share-button facebook" onclick="share('facebook')">
                <i class="fab fa-facebook-f"></i>
                Facebook
            </button>
            <button class="share-button twitter" onclick="share('twitter')">
                <i class="fab fa-twitter"></i>
                Twitter
            </button>
            <button class="share-button linkedin" onclick="share('linkedin')">
                <i class="fab fa-linkedin-in"></i>
                LinkedIn
            </button>
        </div>
    </div>
    <!-- Pagination for Domaines -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalDomainePages; $i++): ?>
                <li class="page-item <?php echo ($i == $currentDomainePage) ? 'active' : ''; ?>">
                    <a class="page-link" href="?domaine_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <p>© 2023 Pinnacle. Tous droits réservés.</p>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src='../../Templates/vendor/jquery/jquery.min.js'></script>
    <script src='../../Templates/vendor/bootstrap/js/bootstrap.bundle.min.js'></script>

    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon"></i>
    </button>

    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            html.setAttribute('data-theme', newTheme);

            // Update icon
            const icon = document.querySelector('.theme-toggle i');
            if (newTheme === 'light') {
                icon.className = 'fas fa-moon';
            } else {
                icon.className = 'fas fa-sun';
            }

            // Save preference
            localStorage.setItem('theme', newTheme);
        }

        // Load saved theme preference
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);

            const icon = document.querySelector('.theme-toggle i');
            if (savedTheme === 'light') {
                icon.className = 'fas fa-moon';
            } else {
                icon.className = 'fas fa-sun';
            }
        });


        let isSpeaking = false; // Track whether speech is currently playing
        let speech; // Store the SpeechSynthesisUtterance instance



        document.addEventListener('DOMContentLoaded', function () {
            const speakButton = document.getElementById('speakButton');
            let isReading = false;

            speakButton.addEventListener('click', function () {
                if (isReading) {
                    window.speechSynthesis.cancel();
                    isReading = false;
                    speakButton.innerHTML = '<i class="fas fa-volume-up"></i> Lire à voix haute';
                } else {
                    const mainContent = document.querySelector('.container.py-5').textContent;

                    const utterance = new SpeechSynthesisUtterance(mainContent);
                    utterance.lang = 'fr-FR';
                    utterance.rate = 1;
                    utterance.pitch = 1;

                    utterance.onend = function () {
                        isReading = false;
                        speakButton.innerHTML = '<i class="fas fa-volume-up"></i> Lire à voix haute';
                    };

                    window.speechSynthesis.speak(utterance);
                    isReading = true;
                    speakButton.innerHTML = '<i class="fas fa-stop"></i> Arrêter la lecture';
                }
            });
        });
        function share(platform) {
            // Get the current page URL and title
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);

            // Custom message for sharing
            const message = encodeURIComponent("Découvrez ce catalogue de cours intéressant sur Pinnacle !");

            // Define sharing URLs for different platforms
            const urls = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
                twitter: `https://twitter.com/intent/tweet?url=${url}&text=${message}`,
                linkedin: `https://www.linkedin.com/shareArticle?url=${url}&title=${title}&summary=${message}`
            };

            // Open sharing window
            const windowFeatures = "width=600,height=400,resizable=yes,scrollbars=yes,status=yes";
            window.open(urls[platform], 'ShareWindow', windowFeatures);
        }

        // Optional: Add success message after sharing
        window.addEventListener('focus', function () {
            // This will run when user returns to your page after sharing
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('shared')) {
                showToast('Merci d\'avoir partagé !');
            }
        });

        // Simple toast notification function
        function showToast(message) {
            // Create toast element if it doesn't exist
            if (!document.getElementById('toast')) {
                const toast = document.createElement('div');
                toast.id = 'toast';
                toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
        `;
                document.body.appendChild(toast);
            }

            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.opacity = '1';

            setTimeout(() => {
                toast.style.opacity = '0';
            }, 3000);
        }

        // Replace the VoiceSearch class with this simplified version
        class VoiceSearch {
            constructor() {
                if (!('webkitSpeechRecognition' in window)) {
                    alert('La reconnaissance vocale n\'est pas supportée par votre navigateur');
                    return;
                }

                this.recognition = new webkitSpeechRecognition();
                this.searchInput = document.getElementById('searchInput');
                this.voiceButton = document.getElementById('voiceSearchBtn');
                this.feedbackElement = document.getElementById('voiceFeedback');

                this.setupRecognition();
                this.setupEventListeners();
            }

            setupRecognition() {
                this.recognition.continuous = false;
                this.recognition.interimResults = false;
                this.recognition.lang = 'fr-FR';

                this.recognition.onstart = () => {
                    this.voiceButton.classList.add('listening');
                    this.showFeedback('Écoute en cours...');
                };

                this.recognition.onend = () => {
                    this.voiceButton.classList.remove('listening');
                    this.hideFeedback();
                };

                this.recognition.onresult = (event) => {
                    const text = event.results[0][0].transcript;
                    this.searchInput.value = text;
                    this.showFeedback(`Recherche: ${text}`);

                    // Submit the search form
                    const searchForm = document.querySelector('form[method="POST"]');
                    const searchInput = searchForm.querySelector('input[name="search"]');
                    searchInput.value = text;
                    searchForm.submit();
                };

                this.recognition.onerror = (event) => {
                    this.showFeedback('Erreur: ' + event.error);
                    this.voiceButton.classList.remove('listening');
                };
            }

            setupEventListeners() {
                this.voiceButton.addEventListener('click', () => {
                    if (this.voiceButton.classList.contains('listening')) {
                        this.recognition.stop();
                    } else {
                        this.recognition.start();
                    }
                });
            }

            showFeedback(message) {
                this.feedbackElement.querySelector('.voice-status').textContent = message;
                this.feedbackElement.classList.add('active');
            }

            hideFeedback() {
                this.feedbackElement.classList.remove('active');
            }
        }

        // Initialize voice search when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            new VoiceSearch();
        });

    </script>





</body>

</html>