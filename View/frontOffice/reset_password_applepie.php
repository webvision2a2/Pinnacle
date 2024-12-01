<?php
include_once  '/../../core/config.php';
include_once  '/../../controllers/UserController.php';

session_start();
$controller = new UserController();
?>

<body>
    <form id="reset-password-form" method="POST" autocomplete="off" novalidate="true">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password">
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password">
    </form>
    <button type="submit" class="nav-button">Reset Password</button>
</body>


<?php
$token = $_GET['token'];
$password = $_POST['password'];//badel name
$confirmPassword = $_POST['confirm_password'];//badel name
echo "token=".$token;
if (empty($_GET['token'])) {
    echo 'LOLOLOLOLO TOKEN FAMECH';
    exit();
}
if ($password === $confirmPassword) {
    $currentPasswordHash = $controller->getCurrentPasswordHashByToken($token);
    if (password_verify($password, $currentPasswordHash)) {
        //dhaharlou erreur tkolou fehaa new pass cannot be the same as the old password.
        echo "passwords cannot be the same";

    } else {
        $resetStatus = $controller->resetPassword($token, $password);
        if ($resetStatus) {
            echo "password updated successfully";
            //dhaharlou info li password mteou updated successfully
        } else {
            echo "reset erreur";
            //dhaharlou erreur
        }
    }
} else {
    echo "passwords do not match";
}
?>


