<?php
// Include the config class for database connection
include '../config.php';

try {
    // Get the database connection
    $db = config::getConnexion();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Update Event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Validate input
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $participants = $_POST['participants'];
    $categories = htmlspecialchars($_POST['categories']);

    // Location inputs
    // Capture location input
$location = htmlspecialchars($_POST['location']);

    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);

    // Handle image upload
$imagePath = ""; // Initialize to avoid undefined variable issues

if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image file
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        exit;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        echo "The file size exceeds the 5MB limit.";
        exit;
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Error uploading the file.";
        exit;
    }

    // Set the new image path
    $imagePath = basename($image);
} else {
    // Retain the existing image if no new file is uploaded
    $stmt = $db->prepare("SELECT image FROM events WHERE id = :eventId");
    $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $imagePath = $result['image']; // Assign the existing image
    } else {
        echo "Event not found or no image available.";
        exit;
    }
}

// Debugging to ensure correct assignment of $imagePath
if (empty($imagePath)) {
    echo "No image found. Please upload an image.";
    exit;
}
// Update event in database
try {
    $query = "UPDATE events SET 
                title = :title, 
                description = :description, 
                date = :date, 
                participants = :participants, 
                categories = :categories, 
                image = :image, 
                location = :location, 
                latitude = :latitude, 
                longitude = :longitude
              WHERE id = :eventId";

    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':participants', $participants);
    $stmt->bindParam(':categories', $categories);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Event updated successfully!";
        header("Location: ../view/BackOffice/tables.php?success=updated");
        exit;
    } else {
        echo "Error updating the event.";
        print_r($stmt->errorInfo()); // Debugging to see if there are SQL errors
        exit;
    }
} catch (PDOException $e) {
    // Handle any exceptions during the database interaction
    echo "Error: " . $e->getMessage();
    exit;
}}

// Fetch Event Data (GET request)
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    try {
        $stmt = $db->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            echo "Event not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Event ID is missing.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<style>
    /* General Styling */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100vw;
    }

    form {
        background-color: #ffffff;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 1200px;
        height: 90%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        box-sizing: border-box;
        overflow-y: auto; /* Enables scrolling for smaller screens */
    }

    h1 {
        text-align: center;
        font-size: 32px;
        color: #333;
        margin-bottom: 25px;
        font-weight: 600;
        width: 100%;
    }

    label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #555;
        font-size: 16px;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 16px;
        color: #333;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus,
    input[type="file"]:focus,
    textarea:focus {
        border-color: #1e1ed8;
        outline: none;
    }

    textarea {
        height: 120px;
    }

    .form-group {
        width: calc(50% - 10px);
    }

    .form-group-full {
        width: 100%;
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        width: 100%;
    }

    button {
        background-color: #1e1ed8;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #007BFF;
    }

    .cancel-button {
        background-color: #888;
    }

    .cancel-button:hover {
        background-color: #555;
    }

    /* Popup error message styles */
    .error-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f7f9fc;
        color: #721c24;
        padding: 15px;
        border: 3px solid #721c24;
        border-radius: 5px;
        font-size: 16px;
        z-index: 9999;
        display: none;
        min-width: 300px;
        text-align: center;
    }

    .error-popup p {
        margin: 0;
    }

    .error-popup button {
        background-color: #721c24;
        color: white;
        border: none;   
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
        display: block; /* makes button a block element */
        width: 100%; /* Makes button full width to center it */
    }

    .error-popup button:hover {
        background-color: #5c1e23;
    }
</style>

</head>
<body>
<form method="POST" enctype="multipart/form-data" >
    <h1>Modifier un événement</h1>
    <input type="hidden" name="eventId" value="<?= htmlspecialchars($event['id']) ?>">

    <!-- Left Column -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($event['title']) ?>" required>
    </div>

    <div class="form-group">
        <label for="participants">Participants</label>
        <input type="number" name="participants" id="participants" value="<?= htmlspecialchars($event['participants']) ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="categories">Categories</label>
        <input type="text" name="categories" id="categories" value="<?= htmlspecialchars($event['categories']) ?>" required>
    </div>
    <div class="form-group">
    <label for="date">Event Date:</label>
    <input type="date" name="date" value="<?= $event['date']; ?>" required>
    </div>
    <!-- Event Location -->
    <div class="form-group">
        <label for="location">Event Location:</label>
        <input type="text" id="location" name="location" value="<?= htmlspecialchars($event['location']) ?>" placeholder="Click on the map to select the location" readonly required>
    </div>

    <!-- Latitude -->
    <input type="hidden" id="latitude" name="latitude" value="<?= htmlspecialchars($event['latitude']) ?>" readonly required>

    <!-- Longitude -->
    <input type="hidden" id="longitude" name="longitude" value="<?= htmlspecialchars($event['longitude']) ?>" readonly required>

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Image upload -->
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image">
    </div>

    <!-- Buttons -->
    <div class="button-group">
        <button type="submit">Sauvegarder</button>
        <button type="button" class="cancel-button" onclick="window.location.href='../view/BackOffice/tables.php'">Annuler</button>
    </div>
</form>

<style>
   #map {
    height: 400px;
    width: 100%;
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

</style>

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

</body>
<script>
      
    document.getElementById('editEventForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission to validate inputs

    // Get input values
    var title = document.querySelector('[name="title"]').value;
    var description = document.querySelector('[name="description"]').value;
    var date = document.querySelector('[name="date"]').value;
    var participants = document.querySelector('[name="participants"]').value;
    var categories = document.querySelector('[name="categories"]').value;

    // Validate each input field and show error popups if necessary
    if (!title || !description || !date || !participants || !categories) {
        showErrorPopup('Veillez remplir tous les champs.');
        return;
    }

    // Additional validation (if necessary, e.g., for date format or number)
    if (isNaN(participants) || participants <= 0) {
        showErrorPopup('le nombre de Participants doit etre positive.');
        return;
    }

    // If all fields are valid, submit the form
    this.submit();
});

// Function to show error popup
function showErrorPopup(message) {
    var popup = document.createElement('div');
    popup.classList.add('error-popup');
    popup.innerHTML = `<p>${message}</p><button onclick="closePopup(this)">Close</button>`;
    document.body.appendChild(popup);
    popup.style.display = 'block';
}

// Function to close the popup
function closePopup(button) {
    button.parentElement.style.display = 'none';
    button.parentElement.remove(); // Remove the popup from the DOM
}

</script>
</html>