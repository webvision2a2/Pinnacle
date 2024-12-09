<?php
// Include the config class for database connection
include '../config.php';

// Get the database connection
$db = config::getConnexion();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Sanitize inputs
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $participants = $_POST['participants'];
    $categories = htmlspecialchars($_POST['categories']);

    // Handle image upload
    $imagePath = "";
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($image);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Attempt upload
        if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = basename($image);
        } else {
            echo "Error uploading the file.";
            $uploadOk = 0;
        }
    } else {
        // Retain the existing image if no new file is uploaded
        $stmt = $db->prepare("SELECT image FROM events WHERE id = :eventId");
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $result['image']; // Existing image path
    }

    // Update the event details in the database
    try {
        $query = "UPDATE events SET 
                    title = :title, 
                    description = :description, 
                    date = :date, 
                    participants = :participants, 
                    categories = :categories, 
                    image = :image 
                  WHERE id = :eventId";

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':participants', $participants);
        $stmt->bindParam(':categories', $categories);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();
        echo "Event updated successfully!";
        header("Location: ../views/events_table.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch event data if editing an existing event
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        echo "Event not found.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
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
        }

        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 600px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
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
            height: 100px;
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
    <form id="editEventForm" action="updateEvent.php" method="POST" enctype="multipart/form-data">
        <h1>Modifier un événement</h1>

        <input type="hidden" name="eventId" value="<?= htmlspecialchars($event['id']) ?>">

        <!-- Left Column -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>">
        </div>

        <div class="form-group">
            <label for="participants">Participants</label>
            <input type="number" name="participants" value="<?= htmlspecialchars($event['participants']) ?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" <?= htmlspecialchars($event['description']) ?>>
        </div>

        <div class="form-group">
            <label for="categories">Categories</label>
            <input type="text" name="categories" value="<?= htmlspecialchars($event['categories']) ?>">
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" value="<?= htmlspecialchars($event['date']) ?>">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image">
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="submit">Sauvegarder</button>
            <button type="button" class="cancel-button" onclick="window.location.href='../view/BackOffice/tables.php'">Annuler</button>
        </div>
    </form>
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
