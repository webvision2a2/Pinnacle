<?php
require_once "google-api/vendor/autoload.php";
$gClient = new Google_Client();
$gClient->setClientId("178187630539-36k91goh9efmoqj8bc9s33dprt9c7nb4.apps.googleusercontent.com");
$gClient->setClientSecret("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");
$gClient->setApplicationName("Pinnacle website");
$gClient->setRedirectUri("http://localhost/Projet_web/View/frontOffice/controller.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

// login URL
$login_url = $gClient->createAuthUrl();
?>