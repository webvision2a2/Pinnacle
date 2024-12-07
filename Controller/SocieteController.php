
<?php

require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Model/societe.php');

class SocieteController
{
    // Liste des sociétés
    public function listSociete() {
        $sql = "SELECT * FROM societe";
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }



    // Suppression d'une société
    public function deleteSociete($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.";
            return;
        }

        $sql = "DELETE FROM societe WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);

        try {
            $req->execute();
            echo "Société supprimée avec succès.";
        } catch (Exception $e) {
            error_log('Error deleting society: ' . $e->getMessage());
            echo "Erreur lors de la suppression de la société.";
        }
    }

    public function addSociete($societe) {
        $sql = "INSERT INTO societe (nom_soc, adresse, numero, email, speciality) VALUES (:nom_soc, :adresse, :numero, :email, :speciality)";
        $db = config::getConnexion();

        try {
            $stmt = $db->prepare($sql);
            $speciality = implode(",", $societe->getSpeciality());
            $stmt->execute([
                'nom_soc' => $societe->getNomSoc(),
                'adresse' => $societe->getAdresse(),
                'numero' => $societe->getNumero(),
                'email' => $societe->getEmail(),
                'speciality' => $speciality
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('Error adding society: ' . $e->getMessage());
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }

    public function updateSociete($societe, $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.";
            return false; // Return false to indicate failure
        }

        try {
            $db = config::getConnexion();

            // Vérifier si la société existe
            $checkQuery = $db->prepare('SELECT id FROM societe WHERE id = :id');
            $checkQuery->execute(['id' => $id]);
            if ($checkQuery->rowCount() == 0) {
                echo "Société introuvable.";
                return false;
            }

            // Préparer la déclaration de mise à jour
            $query = $db->prepare(
                'UPDATE societe SET 
                    nom_soc = :nom_soc,
                    adresse = :adresse,
                    numero = :numero,
                    email = :email,
                    speciality = :speciality
                WHERE id = :id'
            );

            // Exécuter la requête avec les paramètres
            $query->execute([
                'id' => $id,
                'nom_soc' => $societe->getNomSoc(),
                'adresse' => $societe->getAdresse(),
                'numero' => $societe->getNumero(),
                'email' => $societe->getEmail(),
                'speciality' => $societe->getSpeciality() // Assuming this is a string already
            ]);

            echo "Société mise à jour avec succès.";
            return true; // Return true to indicate success
        } catch (PDOException $e) {
            error_log('Error updating society: ' . $e->getMessage());
            echo "Erreur lors de la mise à jour de la société.";
            return false; // Return false on error
        }
    }

    public function showSociete($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.";
            return null;
        }

        $sql = "SELECT * FROM societe WHERE id = :id";
        $db = config::getConnexion();

        try {
            // Préparer et exécuter la requête
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT); // Liaison de l'ID correctement
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC); // Retourner un seul enregistrement sous forme de tableau associatif
        } catch (Exception $e) {
            error_log('Error fetching society: ' . $e->getMessage());
            return null; // Retourner null en cas d'erreur
        }
    }



    // Liste des sociétés
    public function listSocietes() {
        $sql = "SELECT * FROM societe";
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }

    // Afficher une société spécifique
}


?>
