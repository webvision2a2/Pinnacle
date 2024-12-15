<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pinnacle evennements</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="view/FrontOffice/img/LOGO white.png" rel="icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/eventdispo.css">


</head>

<body>
    <audio id="hoverSound" src="../FrontOffice/sound/hover-sound.wav"></audio>

    <div class="container-xxl bg-white p-0">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <img class='logo' src="img/LOGO 1 blue.png">
                <h1 class="m-0">Pinnacle</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="../frontOffice_zeineb/Template/index.php" class="nav-item nav-link">Acceuil</a>
                    <a href="../frontoff/catalogue.php" class="nav-item nav-link"
                            style="color: white;">Catalogue</a>
                    <a href="about.php" class="nav-item nav-link">à Propos</a>
                    <a href="service.php" class="nav-item nav-link">Services</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Evenement </a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addEventModal">Ajouter un événement</a>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </nav>
    <!-- Navbar End -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Ajouter un événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Load the external page inside an iframe -->
                    <iframe src="../FrontOffice/Evenement.php" style="width: 100%; height: 600px; border: none; "></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section Start -->
    <div class="container-xxl py-5 bg-primary hero-header">
        <div class="container my-5 py-5 px-lg-5">
            <div class="row g-5 py-5">
                <div class="col-12 text-center">
                    <h1 class="text-white">Nos Événements</h1>
                </div>
            </div>
        </div>
    </div>



    </div>
    <div class="filters-section" class="center-container">

        <h3 style="text-align: center; color:blue;">Filtrer et Trier les Événements</h3><br>
        <!-- Sound toggle switch -->
        Hover sound

        <div >
  <label>
    <input type="checkbox" id="sound-toggle" />
    <div class="toggle">
      <div class="thumb"></div>
    </div>
  </label>
</div>

        <!-- <h2>Filtrer et Trier les Événements</h2> -->
        Recherche:
        <input type="text" id="searchInput" placeholder="Recherche par titre" onkeyup="searchEvents()" />
        Filtre par categorie:

        <select id="categoryFilter" onchange="sortEvents()">
            <option value="" aria-placeholder="">Tous les evennements</option>
            <option value="Artificial Intelligence">Artificial Intelligence</option>
            <option value="Web Development">Web Development</option>
            <option value="Software Engineering">Software Engineering</option>
            <option value="Cloud Computing">Cloud Computing</option>
            <option value="Blockchain & Cryptocurrency">Blockchain & Cryptocurrency</option>
            <option value="Graphic Design">Graphic Design</option>
            <option value="Game Development">Game Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Cyber Security">Cyber Security</option>
        </select>
        Trier par temps restant:
        <select id="timeSort">
            <option value="asc" selected>Croissant</option>
            <option value="desc">Décroissant</option>
        </select><br>
        <label for="participantSlider">Nombre minimale de participants:</label><br>
        <input type="range" id="participantSlider" class="participant-slider" min="1" max="500" step="1" value="0">
        <div class="slider-value" id="sliderValue" data-toggle="counter-up"></div>



        <button class="event-button3" id="clearFilters" onclick="clearFilters()">Clear Filters</button><br>
        <div id="noResults" style="display: none;">Aucun résultat trouvé.</div>
    </div>
    <form id="registrationForm" method="POST" action="../../Controller/register_event.php">
        <input type="hidden" id="eventId" name="event_id">
        <input type="hidden" id="userId" name="user_id" value="1">
        <?php
        // Include the config class for database connection
        include '../../config_zeineb.php';

        // Get the database connection
        $db = config::getConnexion();

        // Pagination settings
        $itemsPerPage = 8; // Number of events per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Query to get total count of accepted events
        $countQuery = "SELECT COUNT(*) as total FROM events WHERE status = 'accepted'";
        $stmt = $db->prepare($countQuery);
        $stmt->execute();
        $totalEvents = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalEvents / $itemsPerPage);

        // Query to get accepted events with pagination
        $query = "SELECT * FROM events WHERE status = 'accepted' LIMIT :offset, :itemsPerPage";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($events) > 0): ?>
            <div class="events-container">
                <div id="noResultsMessage" style="display: none;">
                    Aucun événement trouvé avec ce titre.
                </div>
                <?php foreach ($events as $event): ?>
                    <div class="event-card" data-event-id="<?= htmlspecialchars($event['id']) ?>" data-category="<?= htmlspecialchars($event['categories']) ?>" data-participants="<?= htmlspecialchars($event['participants']) ?>">
                        <div class="event-title" style="color: #333;"><?= htmlspecialchars($event['title']) ?></div>
                        <img src="../BackOffice/uploads/<?= htmlspecialchars($event['image'] ?? 'default.jpg') ?>" alt="Event Image">
                        <div class="event-details" data-date="<?= htmlspecialchars($event['date']) ?>">
                            <p><strong>Categories:</strong> <?= htmlspecialchars($event['categories']) ?></p>
                        </div>
                        <div class="event-actions">
                            <button type="button" onclick="showEventDetails(<?= htmlspecialchars(json_encode($event)) ?>)" class="event-button1"><span>Détails</span><span></span></button>
                            <button type="button" class="event-button" data-event-id="<?= htmlspecialchars($event['id']) ?>" onclick="showParticipationModal('<?= htmlspecialchars($event['title']) ?>', <?= htmlspecialchars($event['id']) ?>)">
                                <span>Participer</span><span></span>
                            </button>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Controls -->
            <div class="pagination-controls">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>" class="pagination-button">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="pagination-button <?= $i === $currentPage ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>" class="pagination-button">Next</a>
                <?php endif; ?>
            </div><br>


        <?php else: ?>
            <p class="no-events text-center">Pas d'événements disponibles pour le moment.</p>
        <?php endif; ?>
        <!-- Events Section End -->
        </div>
        <!-- Modal for event registration confirmation -->
        <div class="modal fade" id="participationModal" tabindex="-1" aria-labelledby="participationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <div id="emailStatus" style="margin-top: 10px; color: green;"></div>
                        <h5 class="modal-title" id="participationModalLabel">Confirmer votre participation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir participer à cet événement ?</p>
                        <p id="eventNameConfirmation" class="fw-bold"></p>
                        <div id="confirmationMessage" class="mt-3" style="display: none;">
                            <p id="messageText" class="fw-bold"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="event-button2" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="event-button" id="confirmParticipationButton" onclick="registerForEvent()">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventDetailsModalBody">
                    <!-- Event details will be injected dynamically here -->
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        /* Container for the map */
        .map-container {
            width: 100%;
            max-width: 1400px;
            /* Maximum width */
            margin: 0 auto;
            /* Center the map */
            padding: 20px;
            border: 1px solid;
            /* Optional border */
            border-radius: 8px;
            /* Optional rounded corners */
            border-color: blue;
        }

        /* Ensure the map takes up the full height of the container */
        #map {
            width: 100%;
            height: 400px;
            /* You can adjust the height */
        }
    </style>
    <br>
    <h1 style="text-align: center; color:blue;">Notre adresse</h1>
    <h3 style="text-align: center; color:blue;">Pour vous inscrire en personne, nous serons ravis de vous accueillir à notre adresse :</h3>
    <div class="map-container">
        <div id="map"></div><br>
        <div style="display: flex; justify-content: center; text-align: center;">
            <a href="https://www.google.com/maps?q=36.8506,10.2107&hl=en" target="_blank" class="event-button3" style="display: inline-flex; align-items: center; text-decoration: none; color: inherit; border: 1px solid #ccc; padding: 10px 20px; border-radius: 5px;">
                <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> <!-- Google Maps icon -->
                Open in Google Maps
            </a>
        </div>

    </div><br>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get the toggle input element
            const soundToggle = document.getElementById('sound-toggle');

            // Select the audio element
            const hoverSound = document.getElementById('hoverSound');

            // Ensure the audio element exists
            if (!hoverSound) {
                console.error("Audio element not found!");
                return;
            }

            // Buttons that trigger the hover sound
            const soundButtons = document.querySelectorAll('.event-button1, .event-button, .event-button2, .event-button3');

            // Function to play the hover sound
            const playHoverSound = () => {
                if (soundToggle.checked) {
                    hoverSound.currentTime = 0; // Reset sound to the start
                    hoverSound.play().catch(error => {
                        console.warn("Error playing hover sound:", error);
                    });
                }
            };

            // Add hover event listeners to buttons
            soundButtons.forEach(button => {
                button.addEventListener('mouseenter', playHoverSound);
            });

            // Initialize toggle state
            soundToggle.checked = false; // Sound is off by default
        });
    </script>



    <script>
        // Initialize the map and set the view to ESB's coordinates (latitude: 36.8506, longitude: 10.2107)
        var map = L.map('map').setView([36.8506, 10.2107], 15); // Coordinates for ESB (Esprit School of Business)

        // Set up the tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

        }).addTo(map);

        // Add a marker at ESB's location and bind a popup with the address
        L.marker([36.8506, 10.2107]).addTo(map)
            .bindPopup("<b>Pinnacle</b><br />Zone Industrielle Chotrana II, B.P. 160 Pôle Technologique El Ghazela 2083 Ariana, Tunis")
            .openPopup();
    </script>

    <div style="display: flex; justify-content: center; text-align: center;">
        <a href="mailto:pinnacleofficiel@gmail.com"
            class="event-button3"
            style="display: inline-flex; align-items: center; text-decoration: none; color: inherit; border: 1px solid #ccc; padding: 10px 20px; border-radius: 5px;">
            <i class="fas fa-envelope" style="margin-right: 8px;"></i> <!-- Mail icon from Font Awesome -->
            Contacter nous pour plus d'information
        </a>
    </div>


    <!-- Form that will be used to POST data -->
    <!-- Set the correct user ID dynamically -->


</body>
<!-- Footer Start -->
<div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Address<span></span></p>
                <p><i class="fa fa-map-marker-alt me-3"></i>160 Pôle Technologique El Ghazela 2083 Ariana, Tunis</p>
                <p><i class="fa fa-phone-alt me-3"></i>+216 20 804 721</p>
                <p><i class="fa fa-envelope me-3"></i>pinnacleofficiel@gmail.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/kallagui/"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/dhiaallagui.pdf/"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Quick Link<span></span></p>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="mailto:pinnacleofficiel@gmail.com">Contact Us</a>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
                <a class="btn btn-link" href="">Career</a>
            </div>
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Gallery<span></span></p>
                <div class="row g-2">
                    <div class="col-4">
                        <img class="img-fluid" src="img/002-rg-2021-full-lockup-offwhite.jpg" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="img/Skills-needed-to-be-a-good-game-developer-University-of-Bolton.webp" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="img/media_124631e4062698c444e9a7724c90a6b5f3531d6d6.png" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="img/black-hat-logo_0.jpg" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="img/ATOM-Hacker-House-Barcelona-2024.jpg" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="img/portfolio-6.jpg" alt="Image">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Newsletter<span></span></p>
                <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulpu</p>
                <div class="position-relative w-100 mt-3">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                    <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Pinnacle</a>, All Right Reserved.

                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="https://www.instagram.com/dhiaallagui.pdf/">Dhia allagui</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="">Home</a>
                        <a href="">Cookies</a>
                        <a href="">Help</a>
                        <a href="">FQAs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Custom JavaScript -->
<script>
    function validateForm() {
        const eventId = document.getElementById('eventId').value;
        const userId = document.getElementById('userId').value;

        if (!eventId || !userId) {
            alert("Missing event or user information");
            return false;
        }
        return true;
    }

    document.getElementById('registrationForm').onsubmit = validateForm;

    // Show participation confirmation modal with the event title
    function showParticipationModal(eventTitle, eventId) {
        // Set the event title in the modal
        document.getElementById('eventNameConfirmation').textContent = eventTitle;

        // Set the event ID in the hidden input field
        document.getElementById('eventId').value = eventId;

        // Show the modal
        const participationModal = new bootstrap.Modal(document.getElementById('participationModal'));
        participationModal.show();
    }


    // Handle the confirm button click in the participation modal
    document.getElementById('confirmParticipationButton').addEventListener('click', function() {
        // Custom message to display after confirmation
        var confirmationMessage = "Votre participation a été confirmée avec succès. Vous recevrez sous peu un e-mail contenant tous les détails nécessaires concernant l'événement.";

        // Display the message in the modal
        document.getElementById('confirmationMessage').style.display = 'block'; // Show message section
        document.getElementById('messageText').textContent = confirmationMessage; // Set the message text

        // Optionally, disable the confirm button after the message is shown
        document.getElementById('confirmParticipationButton').disabled = true;

        // You can also hide the modal after a short delay
        setTimeout(() => {
            const participationModal = bootstrap.Modal.getInstance(document.getElementById('participationModal'));
            participationModal.hide();
        }, 7000); // Close after 7 seconds (you can adjust this)
    });

    // Show event details in the modal
    function showEventDetails(eventData) {
        const modalTitle = document.getElementById('eventDetailsModalLabel');
        const modalBody = document.getElementById('eventDetailsModalBody');
        const countdownElement = document.getElementById('countdown'); // Make sure to select the countdown element in the modal

        // Set the modal title
        modalTitle.textContent = eventData.title;

        // Inject the event details into the modal body
        modalBody.innerHTML = `
            <p><strong>Description:</strong> ${eventData.description}</p>
            <p><strong>Date:</strong> ${eventData.date}</p>
            <p><strong>Participants:</strong> ${eventData.participants}</p>
            <p><strong>Categories:</strong> ${eventData.categories}</p>
            <p><strong>Adresse:</strong> ${eventData.location}</p>
            <p><strong>Temps Restant:</strong> <span id="countdown"></span></p>
        `;

        // Start the countdown for the event
        updateCountdown(eventData.date);

        // Open the modal
        const detailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        detailsModal.show();
    }

    // Search for events
    function searchEvents() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var eventCards = document.getElementsByClassName('event-card');
        var noResultsMessage = document.getElementById('noResultsMessage');
        var eventsFound = false;

        // Loop through each event card
        for (var i = 0; i < eventCards.length; i++) {
            var eventTitle = eventCards[i].querySelector('.event-title').innerText.toLowerCase();

            // Check if the event title matches the search query
            if (eventTitle.includes(input)) {
                eventCards[i].style.display = 'block'; // Show the event card
                eventsFound = true;
            } else {
                eventCards[i].style.display = 'none'; // Hide the event card if no match
            }
        }

        // Show the "No results found" message if no events match
        if (eventsFound === false && input !== '') {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    // Countdown function
    function updateCountdown(eventDate) {
        const countdownElement = document.getElementById('countdown');
        const targetDate = new Date(eventDate).getTime(); // Assuming eventDate is the event's date

        // Clear any previous countdown intervals
        clearInterval(window.countdownInterval);

        // Start the countdown
        window.countdownInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance <= 0) {
                clearInterval(window.countdownInterval);
                countdownElement.innerHTML = "Event finished!";
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }
        }, 1000);
    }

    // Sort events by category
    function sortEvents() {
        const category = document.getElementById('categoryFilter').value.toLowerCase();
        const eventCards = Array.from(document.querySelectorAll('.event-card')); // Get all event cards

        // Filter events based on the selected category
        eventCards.forEach(card => {
            const eventCategory = card.getAttribute('data-category').toLowerCase(); // Get the category of each event

            // If the selected category is empty, show all events
            if (category === '' || eventCategory === category) {
                card.style.display = ''; // Show the card
            } else {
                card.style.display = 'none'; // Hide the card
            }
        });
    }

    // Sort events by time remaining
    document.getElementById("timeSort").addEventListener("change", function() {
        const sortOrder = this.value; // Get the selected sorting order
        const eventCards = Array.from(document.querySelectorAll(".event-card"));

        eventCards.sort((a, b) => {
            // Extract the event dates from data attributes or other elements
            const dateA = new Date(a.querySelector(".event-details").getAttribute("data-date")).getTime();
            const dateB = new Date(b.querySelector(".event-details").getAttribute("data-date")).getTime();

            // Calculate the time remaining
            const timeRemainingA = dateA - new Date().getTime();
            const timeRemainingB = dateB - new Date().getTime();

            // Compare times based on sort order
            if (sortOrder === "asc") {
                return timeRemainingA - timeRemainingB;
            } else if (sortOrder === "desc") {
                return timeRemainingB - timeRemainingA;
            } else {
                return 0; // No sorting if no option is selected
            }
        });

        // Reorder the event cards in the DOM
        const container = document.querySelector(".events-container");
        eventCards.forEach(card => container.appendChild(card));
    });

    // Clear filters and reset the form
    function clearFilters() {
        document.getElementById("searchInput").value = ''; // Clear the search input
        document.getElementById("categoryFilter").value = ''; // Reset the category filter
        document.getElementById("timeSort").value = 'asc'; // Reset sort to ascending
        document.getElementById("participantSlider").value = 0; // Reset the participant slider
        document.getElementById("sliderValue").textContent = 0; // Reset the participant slider value display
        searchEvents(); // Re-apply search to show all events
        document.getElementById("noResultsMessage").style.display = 'none'; // Hide the "No results found" message

        // Show all events after resetting the filters
        const events = document.querySelectorAll('.event-card');
        events.forEach(event => {
            event.style.display = 'block'; // Ensure all events are visible
        });
    }

    // Add an event listener for the participant slider
    document.getElementById("participantSlider").addEventListener("input", function() {
        var participantValue = parseInt(this.value);
        // Update the slider value display
        document.getElementById("sliderValue").textContent = participantValue;

        // Find all event cards
        var eventCards = document.querySelectorAll(".event-card");

        // Loop through each event card
        eventCards.forEach(function(card) {
            var participants = parseInt(card.getAttribute("data-participants"));

            // Check if the number of participants is greater than the slider value
            if (participants >= participantValue) {
                card.style.display = "block"; // Show the event card
            } else {
                card.style.display = "none"; // Hide the event card
            }
        });
    });

    // Open modal with event ID when the button is clicked
    document.querySelectorAll('.event-button').forEach(button => {
        button.addEventListener('click', function() {
            var eventId = this.getAttribute('data-event-id'); // Get the event ID from the button's data attribute
            var eventTitle = this.getAttribute('data-event-title'); // Get the event title
            openParticipationModal(eventId, eventTitle);
        });
    });

    // Open participation modal with event ID and title
    function openParticipationModal(eventId, eventTitle) {
        // Set the event title in the modal
        document.getElementById('eventNameConfirmation').textContent = eventTitle;

        // Set the event ID and user ID in the hidden form fields
        document.getElementById('eventId').value = eventId;
        document.getElementById('userId').value = $_SESSION['id']; // Set this dynamically based on the logged-in user

        // Store the event ID globally (optional if needed for later)
        selectedEventId = eventId;

        // Show the modal
        $('#participationModal').modal('show');
    }

    // Register for event
    function registerForEvent() {
        // Get the form element
        const form = document.getElementById('registrationForm');

        // Submit the form
        form.submit();
    }

    document.getElementById('sendEmailButton').addEventListener('click', function() {
        const eventId = 123; // Replace with the dynamic event ID
        const requestData = {
            event_id: eventId
        };

        // Disable the button to prevent multiple submissions
        const sendEmailButton = document.getElementById('sendEmailButton');
        sendEmailButton.disabled = true;

        // Display a loading message
        const statusDiv = document.getElementById('emailStatus');
        statusDiv.innerHTML = 'Sending email...';

        // Send an AJAX POST request to the server
        fetch('register_event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                // Handle the response
                if (data.status === 'success') {
                    statusDiv.style.color = 'green';
                    statusDiv.innerHTML = 'Email sent successfully!';
                } else {
                    statusDiv.style.color = 'red';
                    statusDiv.innerHTML = `Failed to send email: ${data.message}`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusDiv.style.color = 'red';
                statusDiv.innerHTML = 'An error occurred while sending the email.';
            })
            .finally(() => {
                // Re-enable the button
                sendEmailButton.disabled = false;
            });
    });

    function handleEventRegistration() {
        let longitude = document.getElementById('longitude').value;
        let latitude = document.getElementById('latitude').value;

        if (!longitude) {
            longitude = null; // Set to null if not available
        }

        if (!latitude) {
            latitude = null; // Set to null if not available
        }

        // Submit the form or make an AJAX request with the longitude and latitude values
        document.getElementById('longitude').value = longitude;
        document.getElementById('latitude').value = latitude;
    }

    function validateForm() {
        let dateField = document.getElementById('date'); // The date input field
        if (!dateField.value) {
            // If the date is missing, set it to the current date or leave it empty
            dateField.value = null; // Allow NULL date if not required
        }
    }
</script>
