<?php
session_start();
include '../../config.php';

// Get the database connection
$db = config::getConnexion();

// Fetch the events
$query = "SELECT * FROM events WHERE status = 'accepted'";
$stmt = $db->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link rel="stylesheet" href="css/evstyles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>
    <style>
         #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        /* Custom Alert Box */
        #customAlert {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: none;
            z-index: 1000;
        }

        #customAlert .btn-close {
            background-color: #fff;
            color: #dc3545;
            border: none;
            padding: 5px 10px;
            margin-top: 10px;
            cursor: pointer;
        }

        #customAlert .btn-close:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
    <div class="container">
        <h1>Ajouter un nouveau événement</h1>

        <!-- Display Success/Failure Message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="message-box success">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="message-box error">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form for adding new event -->
        <form id="addEventForm" action="../../controller/controllerevent.php?action=insertion" method="POST" enctype="multipart/form-data">
        <!-- Event Title -->
            <div class="form-group">
                <label for="eventTitle">Titre d'événement:</label>
                <input type="text" id="eventTitle" name="title" placeholder="Enter event title">
            </div>
            <!-- Categories Section -->
            <h3>Categories:</h3>
            <div class="categories-container">
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option" name="options[]" value="Artificial Intelligence">
                        <span class="checkmark"></span>
                        Artificial Intelligence
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option9" name="options[]" value=" Data Science & Analytics">
                        <span class="checkmark"></span>
                        Data Science & Analytics
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option10" name="options[]" value=" Internet of Things (IoT)">
                        <span class="checkmark"></span>
                        Internet of Things (IoT)
                    </label>
                </div>
               
               
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option8" name="options[]" value=" Web Development">
                        <span class="checkmark"></span>
                        Web Development
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option7" name="options[]" value="Software Engineering">
                        <span class="checkmark"></span>
                        Software Engineering
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option1" name="options[]" value="Cloud Computing">
                        <span class="checkmark"></span>
                        Cloud Computing
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option2" name="options[]" value="Blockchain & Cryptocurrency">
                        <span class="checkmark"></span>
                        Blockchain & Cryptocurrency
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option3" name="options[]" value="Graphic Design">
                        <span class="checkmark"></span>
                        Graphic Design
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option4" name="options[]" value="Game Development">
                        <span class="checkmark"></span>
                        Game Development
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option5" name="options[]" value="Digital Marketing">
                        <span class="checkmark"></span>
                        Digital Marketing
                    </label>
                </div>
                <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option6" name="options[]" value="Cyber Security">
                        <span class="checkmark"></span>
                        Cyber Security
                    </label>
                </div>
                 <div class="checkbox-item">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="option11" name="options[]" value=" Augmented Reality (AR) & Virtual Reality (VR)">
                        <span class="checkmark"></span>
                        Autre Categories
                    </label>
                </div>
            </div>
            



            <!-- Event Description -->
            <div class="form-group">
                <label for="eventDescription">Description:</label>
                <input type="text" name="description" placeholder="Description de l'événement">
            </div>

            <!-- Event Image -->
            <div class="form-group">
                <label for="eventImage">Image d'événement:</label>
                <input type="file" id="eventImage" name="image" accept="image/*">
            </div>

            <!-- Event Date -->
            <div class="form-group">
                <label for="eventDate">Date événement:</label>
                <input type="date" id="eventDate" name="date">
            </div>

            <!-- Number of Participants -->
            <div class="form-group">
                <label for="participants">Nombre de Participants:</label>
                <input type="number" id="participants" name="participants" min="1" placeholder="nombre participants">
            </div>
 <!-- Location -->
 <div class="form-group">
            <label for="location">Event Location:</label>
            <input type="text" id="location" name="location" placeholder="Click on the map to select the location" readonly required>
        </div>

        <!-- Latitude -->
        <div class="form-group">
           
            <input type="text" id="latitude" name="latitude" hidden readonly required>
        </div>

        <!-- Longitude -->
        <div class="form-group">
           
            <input type="text" id="longitude" name="longitude" hidden readonly required>
        </div>

       

    

    <!-- Map Container -->
    <div id="map"></div>
</div>

<script>
    var map = L.map('map').setView([36.8981, 10.1897], 12); // Default view to Tunisia

    // Set up OpenStreetMap layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker;

    // When the map is clicked, add a marker and update latitude, longitude, and location
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // If marker already exists, update it, otherwise add a new one
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        // Update the latitude and longitude input fields
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Reverse geocoding to get the address from the latitude and longitude
        getAddress(lat, lng);
    });

    // Function to get the address using OpenStreetMap Nominatim API
    function getAddress(lat, lng) {
        var xhr = new XMLHttpRequest();
        var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response && response.display_name) {
                    document.getElementById('location').value = response.display_name;
                }
            }
        };
        xhr.send();
    }
</script>
            <!-- Submit and Cancel Buttons -->
         
                <button class="event-button2" type="submit">Ajouter</button>
        </form>
    </div>
</body>
<div id="customAlert" class="message-box error" style="display: none;">
    <span id="errorMessages"></span>
    <button id="closeAlert" class="event-button3">Close</button>
</div>
</form>

</html>
<script>
    document.getElementById('addEventForm').addEventListener('submit', function(event) {
                // Get form inputs
                const title = document.getElementById('eventTitle').value.trim();
                const description = document.querySelector('input[name="description"]').value.trim();
                const image = document.getElementById('eventImage').value;
                const date = document.getElementById('eventDate').value;
                const participants = document.getElementById('participants').value.trim();
                const categories = document.querySelectorAll('input[name="options[]"]:checked');

                // Validation flags
                let isValid = true;
                let errorMessage = '';

                // Title validation
                if (title === '') {
                    isValid = false;
                    errorMessage += 'Le titre de l\'événement est obligatoire.\n';
                }

                // Description validation
                if (description === '') {
                    isValid = false;
                    errorMessage += 'La description de l\'événement est obligatoire.\n';
                }

                // Image validation
                if (image === '') {
                    isValid = false;
                    errorMessage += 'Veuillez sélectionner une image pour l\'événement.\n';
                }

                // Date validation
                if (date === '') {
                    isValid = false;
                    errorMessage += 'La date de l\'événement est obligatoire.\n';
                }

                // Participants validation
                if (participants === '' || isNaN(participants) || participants <= 0) {
                    isValid = false;
                    errorMessage += 'Le nombre de participants doit être un nombre positif.\n';}
                if (participants > 500) {
                        isValid = false;
                        errorMessage += 'Le nombre de participants maximale est 500.\n';
                    }

                    // Categories validation
                    if (categories.length === 0) {
                        isValid = false;
                        errorMessage += 'Veuillez sélectionner au moins une catégorie.\n';
                    }

                    // If not valid, prevent form submission and show errors in custom alert
                    if (!isValid) {
                        event.preventDefault();

                        // Show the custom alert
                        document.getElementById('errorMessages').textContent = errorMessage;
                        document.getElementById('customAlert').style.display = 'block';
                    }
                });

            // Close the custom alert
            document.getElementById('closeAlert').addEventListener('click', function() {
                document.getElementById('customAlert').style.display = 'none';
            });
</script>

</div>
