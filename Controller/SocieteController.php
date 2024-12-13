
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

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
   /*  public function addSociete($societe) {
        $db = config::getConnexion();

        // Vérifier si le nom de la société existe déjà
        $query = $db->prepare("SELECT COUNT(*) FROM societe WHERE nom_soc = :nom_soc");
        $query->execute(['nom_soc' => $societe->getNomSoc()]);
        $count = $query->fetchColumn();
        
        // Debug: Afficher le nombre de sociétés avec ce nom
        error_log("Nombre de sociétés avec ce nom : " . $count);
        
        if ($count > 0) {
            return 'duplicate'; // Nom de société déjà existant
        }

        // Ajouter la société à la base de données
<<<<<<< HEAD
=======
=======
    public function addSociete($societe) {
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
        $sql = "INSERT INTO societe (nom_soc, adresse, numero, email, speciality) VALUES (:nom_soc, :adresse, :numero, :email, :speciality)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'nom_soc' => $societe->getNomSoc(),
                'adresse' => $societe->getAdresse(),
                'numero' => $societe->getNumero(),
                'email' => $societe->getEmail(),
                'speciality' => implode(", ", $societe->getSpeciality())
            ]);
            return 'success';
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la société: " . $e->getMessage());
            return 'error';
        }
    } */

<<<<<<< HEAD

    
    public function addSociete($societe)
    {
        $db = config::getConnexion();
    
        // Vérification si le nom de la société existe déjà dans la base de données
        $query = $db->prepare("SELECT COUNT(*) FROM societe WHERE nom_soc = :nom_soc");
        $query->execute(['nom_soc' => $societe->getNomSoc()]);
        $count = $query->fetchColumn();
    
        // Si le nom de la société existe déjà, on retourne 'duplicate'
        if ($count > 0) {
            $error = "Une société avec ce nom existe déjà. Veuillez en choisir un autre.";
            return 'duplicate'; 
        }
        
    
        // Préparer la requête d'insertion dans la base de données
        $sql = "INSERT INTO societe (nom_soc, adresse, numero, email, speciality) VALUES (:nom_soc, :adresse, :numero, :email, :speciality)";
        
        try {
            // Préparer la requête
            $stmt = $db->prepare($sql);
            
            // Exécuter la requête d'insertion avec les données de la société
            $stmt->execute([
                'nom_soc' => $societe->getNomSoc(),
                'adresse' => $societe->getAdresse(),
                'numero' => $societe->getNumero(),
                'email' => $societe->getEmail(),
                'speciality' => implode(", ", $societe->getSpeciality()) // Convertir le tableau des spécialités en chaîne de caractères
            ]);
            
            // Si l'insertion est réussie, retourner 'success'
            return 'success';
        } catch (PDOException $e) {
            // Si une exception se produit (erreur lors de l'insertion), on l'enregistre dans les logs et retourne 'error'
            error_log("Erreur lors de l'ajout de la société: " . $e->getMessage());
            return 'error';
        }
    }  

<<<<<<< HEAD
=======
=======
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
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

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
        // Ajouter cette méthode pour gérer la recherche et la pagination
        public function searchAndPaginate($searchTerm = '', $limit, $offset) {
            $db = config::getConnexion();
            $sql = "SELECT * FROM societe WHERE nom_soc LIKE :searchTerm LIMIT :limit OFFSET :offset";
            try {
                $stmt = $db->prepare($sql);
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
        public function countSearchResults($searchTerm = '') {
            $db = config::getConnexion();
            $sql = "SELECT COUNT(*) as count FROM societe WHERE nom_soc LIKE :searchTerm";
            try {
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result['count'];
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
                return 0;
            }
        
        }
    
    public function getSocieteById($id) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM societe WHERE id = :id";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }

    
<<<<<<< HEAD
=======
=======
    // Afficher une société spécifique
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
}


?>
