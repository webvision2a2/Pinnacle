<?php

require_once(__DIR__ . '/../config.php');

class CandidatureController
{
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
    public function deleteCandidature($id)
    {
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

    // Ajouter une candidature
    public function addCandidature($candidature) {
        $sql = "INSERT INTO candidatures (nom, prenom, numero, email, cv, id_stage) VALUES (:nom, :prenom, :numero, :email, :cv, :id_stage)";
        $db = config::getConnexion();

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'nom' => $candidature->getNom(),
                'prenom' => $candidature->getPrenom(),
                'numero' => $candidature->getNumero(),
                'email' => $candidature->getEmail(),
                'cv' => $candidature->getCv(),  // Chemin du CV téléchargé
                'id_stage' => $candidature->getIdStage()
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('Erreur lors de l\'ajout de la candidature: ' . $e->getMessage());
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }

    // Mettre à jour une candidature
    public function updateCandidature($candidature, $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo "ID invalide.";
            return false;
        }

        try {
            $db = config::getConnexion();

            // Vérifier si la candidature existe
            $checkQuery = $db->prepare('SELECT id FROM candidatures WHERE id = :id');
            $checkQuery->execute(['id' => $id]);
            if ($checkQuery->rowCount() == 0) {
                echo "Candidature introuvable.";
                return false;
            }

            // Préparer la déclaration de mise à jour
            $query = $db->prepare(
                'UPDATE candidatures SET 
                    nom = :nom,
                    prenom = :prenom,
                    numero = :numero,
                    email = :email,
                    cv = :cv
                WHERE id = :id'
            );

            // Exécuter la requête avec les paramètres
            $query->execute([
                'id' => $id,
                'nom' => $candidature->getNom(),
                'prenom' => $candidature->getPrenom(),
                'numero' => $candidature->getNumero(),
                'email' => $candidature->getEmail(),
                'cv' => $candidature->getCv()  // Le CV mis à jour
            ]);

            echo "Candidature mise à jour avec succès.";
            return true;
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de la candidature: ' . $e->getMessage());
            echo "Erreur lors de la mise à jour de la candidature.";
            return false;
        }
    }

    // Afficher une candidature spécifique
    public function showCandidature($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo "ID invalide.";
            return null;
        }

        $sql = "SELECT * FROM candidatures WHERE id = :id";
        $db = config::getConnexion();

        try {
            // Préparer et exécuter la requête
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT); // Liaison de l'ID correctement
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC); // Retourner un seul enregistrement sous forme de tableau associatif
        } catch (Exception $e) {
            error_log('Erreur lors de la récupération de la candidature: ' . $e->getMessage());
            return null; // Retourner null en cas d'erreur
        }
    }
}

?>
