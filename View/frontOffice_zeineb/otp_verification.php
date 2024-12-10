<?php
session_start();

include(__DIR__ . '/../../config_zeineb.php');
$pdo = config::getConnexion();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otp'])) {
    // Sanitize OTP input
    $otp = filter_var($_POST['otp'], FILTER_SANITIZE_STRING);

    // Check if `temp_user` exists in the session
    if (isset($_SESSION['temp_user']) && isset($_SESSION['temp_user']['email']) && isset($_SESSION['temp_user']['role'])) {
        $email = $_SESSION['temp_user']['email'];
        $role = $_SESSION['temp_user']['role'];

        try {
            

            // Query to validate OTP
            $sql = "
                SELECT email FROM user_otps 
                WHERE email = :email AND otp = :otp AND expires_at >= NOW()
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':otp', $otp);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "OTP is valid. Deleting entry.\n";

                    // Delete the OTP from the table
                    $deleteSql = "DELETE FROM user_otps WHERE email = :email";
                    $deleteStmt = $pdo->prepare($deleteSql);
                    $deleteStmt->bindParam(':email', $email);
                    $deleteStmt->execute();

                    echo "Entry deleted.\n";

                    // Set session for logged-in user
                    $_SESSION["loggedin"] = true;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = $role;

                    // Redirect based on user role
                    if ((int)$role === 2) {
                        header("Location: Template/index.php");
                    }
                    exit;
                } else {
                    // OTP invalid or expired
                    echo "OTP not valid or expired.\n";
                    $_SESSION['error'] = "OTP invalide ou expiré.";
                    header("Location: otp_verification.php");
                    exit;
                }
            } else {
                echo "Error executing SELECT query.\n";
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Database error: " . $e->getMessage();
            $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer.";
            header("Location: otp_verification.php");
            exit;
        }
    } else {
        // Redirect or show error if `temp_user` is not set
        echo "Session 'temp_user' not set. Unable to verify OTP.\n";
        $_SESSION['error'] = "Session expirée. Veuillez réessayer.";
        header("Location: login.php"); // Redirect to login or appropriate page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - Pinnacle</title>
    <!-- Favicon -->
    <link href="Template/img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap and Custom Stylesheet -->
    <link href="Template/css/bootstrap.min.css" rel="stylesheet">
    <link href="Template/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white d-flex flex-column align-items-center justify-content-center vh-100">
        <!-- Logo et Titre Centrés -->
        <div class="text-center mb-4">
            <h1 class="m-0" style="color: #2C24CE ;"><img class="logo" src="Template/img/LOGO 1 blue.png" alt="Pinnacle Logo" style="max-width: 45px;">Pinnacle</h1>
        </div>

        <div class="card p-5 shadow-lg border-0" style="max-width: 400px; width: 100%;">
        <p class="mb-4" style="font-size: 16px;">
            Pour vérifier votre identité et finaliser la connexion, veuillez entrer le code OTP que vous avez reçu par email. Ce code est composé de 6 chiffres.
        </p>
            <form id="otpForm" method="post" action="otp_verification.php">
                <div class="form-group mb-3">
                    <label for="otp">Entrez votre OTP :</label>
                    <input type="text" class="form-control" name="otp" title="OTP should be a 6-digit number">
                    <p id="errorMessage" style="color: red; display: none;"></p>
                </div>
                <button type="submit" class="btn btn-primary btn-block w-100 rounded-pill">Vérifier</button>
            </form>
            <form id="resendForm" method="post" action="resend_otp.php" class="mt-3">
                <button type="submit" class="btn btn-secondary btn-block w-100 rounded-pill">Renvoyer le code</button>
            </form>

        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Template/lib/wow/wow.min.js"></script>
    <script src="Template/lib/easing/easing.min.js"></script>
    <script src="Template/lib/waypoints/waypoints.min.js"></script>
    <script src="Template/lib/counterup/counterup.min.js"></script>
    <script src="Template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="Template/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="Template/lib/lightbox/js/lightbox.min.js"></script>
    <!-- Template Javascript -->

<script>
    document.getElementById('otpForm').addEventListener('submit', function(event) {
    const otpInput = document.getElementById('otp');
    const otp = otpInput.value;
    const errorMessage = document.getElementById('errorMessage');
    
    // Regular expression to match a 6-digit number
    const otpPattern = /^\d{6}$/;
    
    // Check if OTP matches the pattern
    if (!otpPattern.test(otp)) {
        errorMessage.textContent = 'OTP doit contenir 6 chiffres.'; // Set error message text
        errorMessage.style.display = 'block'; // Display the error message
        otpInput.focus(); // Focus back on the OTP input field
        event.preventDefault(); // Prevent form submission
    } else {
        errorMessage.style.display = 'none'; // Hide error message if OTP is valid
    }
});

</script>
</body>
</html>

<?php
// Display any error messages
if (isset($_SESSION['error'])) {
    echo "<p class='error-message'>{$_SESSION['error']}</p>";
    unset($_SESSION['error']);
}
?>

