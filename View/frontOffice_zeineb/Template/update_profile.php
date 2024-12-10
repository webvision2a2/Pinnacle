<?php

session_start();
// Assuming you've already included the database connection file
include_once '../../../config_zeineb.php'; // Modify this path as per your project structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for file upload errors
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/uploads/";

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        // Get the uploaded file's name and generate the full path
        $uploadedFile = $uploadDir . basename($_FILES['file']['name']);
        
        // Move the file to the upload directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
            echo "File uploaded successfully to: " . $uploadedFile;

            // Connect to the database using PDO
            try {
                $pdo = config::getConnexion(); // Assuming config::getConnexion() is a method for connecting to the database

                // Prepare the SQL query to insert the file path into the database
                $sql = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
                
                // Prepare the statement
                $stmt = $pdo->prepare($sql);

                // Execute the statement with the file path and user_id
                $stmt->execute([
                    ':photo_profil' => 'uploads/' . basename($_FILES['file']['name']), // Store the relative path
                    ':user_id' => $_SESSION['id'] // Assuming the user's ID is stored in the session
                ]);

            

                echo '<div id="message_success">Picture Changed</div>';
                /* echo '<script>document.location="profile_edit.php";</script>'; */
            } catch (PDOException $e) {
                // Handle database connection errors
                echo "Database error: " . $e->getMessage();
            }

        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . ($_FILES['file']['error'] ?? "No file uploaded");
    }
    if (!isset($_SESSION['id'])) {
        echo "Session user ID not found.";
        exit;
    }

    echo "Uploaded file: " . $_FILES['file']['name'];
    echo "Temporary file location: " . $_FILES['file']['tmp_name'];

}
?>









