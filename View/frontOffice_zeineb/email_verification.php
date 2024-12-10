<?php
require_once '../../Controller/UserController.php';
session_start();


// Retrieve the token from the URL
$token = $_GET['token'] ?? null;

if (!$token) {
    $message = 'Token is missing.';
    $status = 'error';
} else {
    // Instantiate the UserController
    $controller = new UserController();

    // Check if the token is valid and verify the email
    $resetStatus = $controller->verifyEmail($token);

    if ($resetStatus) {
        $message = 'Votre adresse e-mail a été vérifiée avec succès!';
        $status = 'success';
    } else {
        $message = 'Échec de la vérification ! Le jeton est invalide ou a expiré. Veuillez demander un nouvel e-mail de vérification.';
        $status = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .verification-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .btn-custom {
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .message-success {
            color: green;
        }
        .message-error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <?php if (isset($message)): ?>
            <h2 class="<?php echo $status === 'success' ? 'message-success' : 'message-error'; ?>">
                <?php echo $message; ?>
            </h2>
            <?php if ($status === 'success'): ?>
                <a href="login.php" class="btn-custom">Aller à la Page de Connexion</a>
            <?php else: ?>
                <a href="signup.php" class="btn-custom">Retour à l'inscription</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

