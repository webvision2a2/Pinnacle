<?php
require_once "../../Controller/UserController.php";
require_once "google_login_config.php";

if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
}/* else{
     header('Location: login.php'); 
    exit();
} */
/* if(isset($token["error"]) && ($token["error"] != "invalid_grant")){ */
    // get data from google
    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

    echo '<pre>';
    var_dump($userData);
    echo '</pre>';

    //insert data in the database
    $Controller = new UserController;
    echo $Controller -> insertData(
        array(
            'email' => $userData['email'], // Keep email
            'givenName' => $userData['givenName'], // This will map to 'prenom'
            'familyName' => $userData['familyName'], // This will map to 'nom'
            'role' => 2, // You can set the default role as 2 'client'
            'verification' => 1, // You can set default verification status as 1 (verified)
        )
    );
/* else{
    header('Location: login.php');
    exit();
} */
?>

