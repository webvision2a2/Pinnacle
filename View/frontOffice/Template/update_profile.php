<!-- <?php 
/* if(isset($_POST["submit"])){
    $user_id = $_POST['user_id'];
    $name = $_FILES['photo_profil']['name'];
    $tmp_name = $_FILES['photo_profil']['name'];
    

    if($name){
        $name = time();
        $picture = "user_pictures/$name.jpg";
    }
    move_uploaded_file($tmp_name , $picture);

    include_once '../../../config.php';

    $pdo = config::getConnexion();

    $sql_update_statement  = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
    $statement = $pdo->prepare($sql_update_statement);
    $statement->execute(["photo_profil" => $picture, "user_id => $user_id"]);

?>

<div id="message_success">Picture Changed</div>
<script>
    document.location="profile_edit.php";
</script>
<?php
} */
?> -->
<!-- <?php
/* if (isset($_POST["submit"])) {
    $user_id = $_POST['user_id'];
    $name = $_FILES['photo_profil']['name'];
    /* $tmp_name = $_FILES['photo_profil']['name']; 

    // Check if a file was uploaded
    if ($name) {
        // Generate a unique name for the file
        /* $name = time(); */ // Use the current timestamp for uniqueness
        /* $picture = "user_pictures/$name.jpg"; 
        $picture = __DIR__ . "/user_pictures/$name.jpg";


        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $picture)) {
            // Include database configuration
            include_once '../../../config.php';

            $pdo = config::getConnexion();

            // Update the database with the new file path
            $sql_update_statement = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
            $statement = $pdo->prepare($sql_update_statement);
            $statement->execute(["photo_profil" => $picture, "user_id" => $user_id]);

            echo '<div id="message_success">Picture Changed</div>';
            echo '<script>document.location="profile_edit.php";</script>';
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "No file uploaded.";
    }
} */
?> -->

<!-- <?php
/* if (isset($_POST["submit"])) {
    $user_id = $_POST['user_id']; // Ensure this is provided in the form
    $name = $_FILES['photo_profil']['name'];

    // Check for upload errors
    if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
        // Set up upload directory
        $upload_dir = __DIR__ . "/img/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Generate unique file name
        $unique_name = uniqid() . "_" . basename($name);
        $picture = $upload_dir . $unique_name;

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($_FILES['photo_profil']['type'], $allowed_types)) {
            // Move the uploaded file
            if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $picture)) {
                // Save relative path in database
                $db_picture_path = "user_pictures/" . $unique_name;

                // Include database configuration
                include_once '../../../config.php';
                $pdo = config::getConnexion();

                // Update database
                $sql_update_statement = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
                $statement = $pdo->prepare($sql_update_statement);
                $statement->execute(["photo_profil" => $db_picture_path, "user_id" => $user_id]);

                echo '<div id="message_success">Picture Changed</div>';
                echo '<script>document.location="profile_edit.php";</script>';
            } else {
                echo "Error moving uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPEG and PNG are allowed.";
        }
    } else {
        echo "File upload error: " . $_FILES['photo_profil']['error'];
    }
} */
?> -->

<!-- <?php
/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for errors
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/uploads/";
        
        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uploadedFile = $uploadDir . basename($_FILES['file']['name']);

        // Move file
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
            echo "File uploaded successfully to: " . $uploadedFile;
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . ($_FILES['file']['error'] ?? "No file uploaded");
    }
} */
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form> -->


<!-- <?php
/* if (isset($_POST["submit"])) {
    $name = $_FILES['photo_profil']['name'];

    // Check if a file was uploaded
    if ($name) {
        // Generate a unique name for the file (optional)
        $name = time() . "_" . basename($name); // Ensures uniqueness
        
        // Define the target directory
        $uploadDir = __DIR__ . "/uploads/";

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Define the target file path
        $targetFile = $uploadDir . $name;

        // Check file upload errors
        if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $targetFile)) {
                // Include database configuration
                include_once '../../../config.php';

                $pdo = config::getConnexion();

                // Update the database with the new file path
                $sql_update_statement = "UPDATE profiles SET photo_profil = :photo_profil WHERE user_id = :user_id";
                $statement = $pdo->prepare($sql_update_statement);
                $statement->execute([
                    "photo_profil" => $targetFile,
                    "user_id" => $user_id, // Ensure $user_id is set
                ]);

                echo '<div id="message_success">Picture Changed</div>';
                /* echo '<script>document.location="profile_edit.php";</script>';
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "File upload error: " . $_FILES['photo_profil']['error'];
        }
    } else {
        echo "No file uploaded.";
    }
} */
?> -->


<?php

session_start();
// Assuming you've already included the database connection file
include_once '../../../config.php'; // Modify this path as per your project structure

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

<!-- HTML form for uploading the file -->
<!-- <form action="update_profile.php" method="POST" enctype="multipart/form-data">
    <div class="mt-3">
        <h4>
            <?php echo $_SESSION["nom"] . " " . $_SESSION["prenom"]; ?>
        </h4>
        <div class="mt-3">
            <label for="fileInput">Changer la photo de profil</label>
            <input type="file" name="file" id="fileInput" class="form-control">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
            <div class="message" style="color: red; margin-top: 10px;"></div>
            <button type="submit" name="submit" class="btn btn-primary submit">Enregistrer</button>
        </div>
    </div>
</form> -->







