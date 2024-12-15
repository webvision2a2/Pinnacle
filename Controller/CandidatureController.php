<?php
require_once(__DIR__ . '/../config_zeineb.php');
// Assuming this is the start of your CandidatureController class
require_once (__DIR__ . '../../vendor/autoload.php');
    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CandidatureController
{
    public function envoyerEmail($email,$etat)
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Enable debugging for troubleshooting
            $mail->SMTPDebug = 3; 
            $mail->Debugoutput = 'html';
            
            // Set up SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ahmed.hebaieb@gmail.com'; // Your email
            $mail->Password = 'lgft nqyc fhul rthh'; // Your SMTP app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;

            // Sender and recipient
            $mail->setFrom('ahmed.hebaieb@gmail.com', 'projet');
            $mail->addAddress($email); // Add the recipient's email

            // Email content
            $mail->isHTML(true);
            if ($etat === 'acceptée') {
                $mail->Subject = 'Candidature Acceptee';
                $mail->Body    = 'Félicitations! Votre candidature a été acceptée pour le stage.';
            } else {
                $mail->Subject = 'Candidature Refusee';
                $mail->Body    = 'Désolé, votre candidature pour le stage a été refusée. Nous vous remercions de votre intérêt.';
            }

            // Send the email
            $mail->send();
            echo 'Email envoyé avec succès.';
            error_log("Email envoyé avec succès à $email pour le sujet : 'mail'.");

        } catch (Exception $e) {
            // Log any error that occurs during the email sending process
            error_log("Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo);
            echo "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
        }
    }
    // Liste des candidatures pour un stage spécifique
    public function listCandidaturesForStage($id_stage) {
        $sql = "SELECT * FROM candidatures WHERE id_stage = :id_stage";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }

    // Suppression d'une candidature
    public function deleteCandidature($id) {
        if (!is_numeric($id) || $id <= 0) {
            echo "ID invalide.";
            return;
        }

        $sql = "DELETE FROM candidatures WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);

        try {
            $req->execute();
            echo "Candidature supprimée avec succès.";
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression de la candidature: ' . $e->getMessage());
            echo "Erreur lors de la suppression de la candidature.";
        }
    }
    
    public function addCandidature($candidature) {
        // Récupérer le fichier CV et le déplacer dans le répertoire souhaité
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $cvDir = "C:/xampp/htdocs/projet web/View/frontofficeahmed/cv/";  // Le répertoire où stocker les CV
            $cvTmpName = $_FILES['cv']['tmp_name'];
            $cvName = basename($_FILES['cv']['name']);
            $cvPath = $cvDir . $cvName;

            // Déplacer le fichier dans le répertoire de stockage
            if (move_uploaded_file($cvTmpName, $cvPath)) {
                // Enregistrer les informations de la candidature dans la base de données
                $sql = "INSERT INTO candidatures (nom, prenom, numero, email, cv, id_stage, etat, id_user) 
                        VALUES (:nom, :prenom, :numero, :email, :cv, :id_stage, :etat, :id_user)";
                $db = config::getConnexion();

                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        'nom' => $candidature->getNom(),
                        'prenom' => $candidature->getPrenom(),
                        'numero' => $candidature->getNumero(),
                        'email' => $candidature->getEmail(),
                        'cv' => 'cv/' . $cvName, // Enregistrer le chemin relatif du CV
                        'id_stage' => $candidature->getIdStage(),
                        'etat' => 'en cours',
                        'id_user' => $candidature->getIdUser() // Ajouter id_user dans l'insertion
                    ]);
                    return true;
                } catch (PDOException $e) {
                    error_log('Erreur lors de l\'ajout de la candidature: ' . $e->getMessage());
                    echo "Erreur: " . $e->getMessage();
                    return false;
                }
            } else {
                echo "Erreur lors de l'upload du fichier CV.";
                return false;
            }
        } else {
            echo "Aucun fichier CV téléchargé ou erreur de téléchargement.";
            return false;
        }
    }
    // Ajouter une candidature
    /* public function addCandidature($candidature) {
        // Récupérer le fichier CV et le déplacer dans le répertoire souhaité
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $cvDir = "C:/xampp/htdocs/projet web/View/frontofficeahmed/cv/";  // Le répertoire où stocker les CV
            $cvTmpName = $_FILES['cv']['tmp_name'];
            $cvName = basename($_FILES['cv']['name']);
            $cvPath = $cvDir . $cvName;

            // Déplacer le fichier dans le répertoire de stockage
            if (move_uploaded_file($cvTmpName, $cvPath)) {
                // Enregistrer les informations de la candidature dans la base de données
                $sql = "INSERT INTO candidatures (nom, prenom, numero, email, cv, id_stage, etat) 
                        VALUES (:nom, :prenom, :numero, :email, :cv, :id_stage, :etat)";
                $db = config::getConnexion();

                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        'nom' => $candidature->getNom(),
                        'prenom' => $candidature->getPrenom(),
                        'numero' => $candidature->getNumero(),
                        'email' => $candidature->getEmail(),
                        'cv' => 'cv/' . $cvName, // Enregistrer le chemin relatif du CV
                        'id_stage' => $candidature->getIdStage(),
                        'etat' => 'en cours'
                    ]);
                    return true;
                } catch (PDOException $e) {
                    error_log('Erreur lors de l\'ajout de la candidature: ' . $e->getMessage());
                    echo "Erreur: " . $e->getMessage();
                    return false;
                }
            } else {
                echo "Erreur lors de l'upload du fichier CV.";
                return false;
            }
        } else {
            echo "Aucun fichier CV téléchargé ou erreur de téléchargement.";
            return false;
        }
    } */

    // Méthode pour mettre à jour l'état de la candidature
    public function updateEtat($id, $etat) {
        $conn = config::getConnexion();

        $sql = "UPDATE candidatures SET etat = :etat WHERE id = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':etat', $etat);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Afficher une candidature spécifique (incluant l'état)
    public function showCandidature($id) {
        if (!is_numeric($id) || $id <= 0) {
            echo "ID invalide.";
            return null;
        }

        $sql = "SELECT * FROM candidatures WHERE id = :id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération de la candidature: ' . $e->getMessage());
            return null;
        }
    }

    // Récupérer une candidature par son ID
    public function getCandidatureById($id) {
        $conn = config::getConnexion();

        $sql = "SELECT * FROM candidatures WHERE id = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour gérer la recherche et la pagination
    public function searchAndPaginate($id_stage, $searchTerm = '', $limit, $offset) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM candidatures WHERE id_stage = :id_stage AND (nom LIKE :searchTerm OR prenom LIKE :searchTerm) LIMIT :limit OFFSET :offset";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }

    // Compter le nombre de résultats pour la recherche
    public function countSearchResults($id_stage, $searchTerm = '') {
        $db = config::getConnexion();
        $sql = "SELECT COUNT(*) as count FROM candidatures WHERE id_stage = :id_stage AND (nom LIKE :searchTerm OR prenom LIKE :searchTerm)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return 0;
        }
    }
}
?>
