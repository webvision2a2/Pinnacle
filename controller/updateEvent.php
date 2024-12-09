<?php
// Include the config to access the database connection
include '../config.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the event ID is provided
    if (!isset($_POST['eventId']) || empty($_POST['eventId'])) {
        die('No event ID provided.');
    }

    // Get form data
    $eventId = $_POST['eventId'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $participants = $_POST['participants'];
    $categories = trim($_POST['categories']);
    $image = $_FILES['image']['name'] ?? '';

 

    // Get the PDO connection
    $pdo = config::getConnexion();

    try {
        // Prepare the base SQL update query
        $sql = "UPDATE events SET 
                    title = :title, 
                    description = :description, 
                    date = :date, 
                    participants = :participants, 
                    categories = :categories";

        // Check if a new image is uploaded
        if (!empty($image)) {
            $sql .= ", image = :image";
        }

        $sql .= " WHERE id = :eventId";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':participants', $participants);
        $stmt->bindParam(':categories', $categories);
        $stmt->bindParam(':eventId', $eventId);

        // If a new image is uploaded, handle the file upload and bind the image
        if (!empty($image)) {
            $target_dir = "../../uploads/";
            $target_file = $target_dir . basename($image);
            $uploadOk = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            if ($uploadOk) {
                $stmt->bindParam(':image', $image);
            } else {
                die('Error uploading the file.');
            }
        }

        // Execute the query to update the event
        $stmt->execute();

        // Redirect to the events list
        header("Location: ../view/BackOffice/tables.php");
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    die('Invalid request.');
}
?>
