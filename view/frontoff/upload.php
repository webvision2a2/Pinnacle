<?php
include   '../../Models/Domaine.php';
include '../../Controller/CRUD.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "view\backoff\Templates\uploads"; // Directory where images will be stored
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert into database
            adddomaines($name, $description, $targetFile); // Assuming you have this function defined in CRUD.php
            header("view\backoff\dashboard.php"); // Redirect after successful upload
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>