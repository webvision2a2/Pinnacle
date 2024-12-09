<?php

require_once '../../Controller/Services/MailingService.php';

// Après l'ajout d'un nouveau cours
if($coursAjoute) {
    $mailing = new MailingService();
    
    // Exemple avec un tableau d'utilisateurs
    $utilisateurs = [
        ['email' => 'user1@example.com'],
        ['email' => 'user2@example.com']
    ];
    
    foreach($utilisateurs as $user) {
        $result = $mailing->sendCourseNotification($user['email'], $nomCours);
        if($result !== true) {
            // Gérer l'erreur
            error_log("Erreur d'envoi de notification : " . $result);
        }
    }
} 