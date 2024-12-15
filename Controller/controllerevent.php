<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the config to access the database connection
include '../config_zeineb.php';

// Start the session to manage flash messages
session_start();

// Get the PDO connection
$db = config::getConnexion();

// Handle event creation logic (for the event addition form)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    // Sanitize user inputs
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $participants = $_POST['participants'];
    $location = htmlspecialchars($_POST['location']);  // New location input

    // Handle categories (checkboxes)
    $categories = isset($_POST['options']) ? implode(', ', $_POST['options']) : '';

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['error'] = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Limit file size (5MB max for example)
    if ($_FILES["image"]["size"] > 5000000) { // 5MB
        $_SESSION['error'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if everything is okay to upload the file
    if ($uploadOk == 0) {
        $_SESSION['error'] = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_SESSION['success'] = "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    }

    // If file upload is successful, proceed with database insertion
    if ($uploadOk === 1) {
        try {
            // Prepare the SQL statement for event insertion, including the location
            $sql = "INSERT INTO events (title, description, image, date, participants, categories, location) 
                    VALUES (:title, :description, :image, :date, :participants, :categories, :location)";

            // Prepare the query
            $stmt = $db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $target_file);  // Store the full path of the image
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':participants', $participants);
            $stmt->bindParam(':categories', $categories);
            $stmt->bindParam(':location', $location);  // Bind the location parameter

            // Execute the query
            $stmt->execute();

            // Display success message and set session variable
            $_SESSION['success'] = "Event added successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    }

    // Redirect back to the form page (staying on the same page)
    header("Location: ../view/FrontOffice/Evenement.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'accept' && isset($_GET['eventId'])) {
    $eventId = $_GET['eventId']; // Get the event ID from the query string

    if (!empty($eventId) && is_numeric($eventId)) {
        try {
            // Update the event's status to "accepted"
            $query = "UPDATE events SET status = 'accepted' WHERE id = :eventId";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to another page or display success
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Invalid event ID.";
    }
}
?>
