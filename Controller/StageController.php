<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
/* 
=======

/* require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Model/stage.php');

class StageController
{
    // Liste des stages
    public function listStage() {
        $sql = "SELECT * FROM stage";
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }

    
    public function deleteStage($id) {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.<br>"; // Message de débogage
            return false; // Return false on invalid ID
        }
    
        $sql = "DELETE FROM stage WHERE id_stage = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
    
        try {
            $req->execute();
            echo "Stage supprimé avec succès.<br>"; // Message de débogage
            return true; // Return true on success
        } catch (PDOException $e) {
            // More specific error handling for database issues
            error_log('Error deleting stage: ' . $e->getMessage());
            echo "Erreur lors de la suppression du stage: " . $e->getMessage() . "<br>"; // Message de débogage
            return false; // Return false on error
        }
    }
    
    
    

   
    public function addStage($stage) {
        // Vérifiez si l'id_societe est valide
        if (!is_numeric($stage->getIdSociete()) || $stage->getIdSociete() <= 0) {
            echo "ID de société invalide.<br>";
            return false;
        }

        $sql = "INSERT INTO stage (nom_stage, type, duration, email, speciality, documents, id_societe)
                VALUES (:nom_stage, :type, :duration, :email, :speciality, :documents, :id_societe)";
        $db = config::getConnexion();

        try {
            $stmt = $db->prepare($sql);
            $speciality = implode(",", $stage->getSpeciality());  // Convertir les spécialités en chaîne de caractères

            // Exécuter la requête avec les valeurs de l'objet $stage
            $stmt->execute([
                'nom_stage' => $stage->getNomStage(),
                'type' => $stage->getType(),
                'duration' => $stage->getDuration(),
                'email' => $stage->getEmail(),
                'speciality' => $speciality,
                'documents' => $stage->getDocuments(),
                'id_societe' => $stage->getIdSociete()
            ]);

            echo "Stage ajouté avec succès !<br>";
            return true;
        } catch (PDOException $e) {
            error_log('Erreur lors de l\'ajout du stage: ' . $e->getMessage());
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }

    // Mise à jour d'un stage
    public function updateStage($stage, $id) {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.";
            return false;
        }

        try {
            $db = config::getConnexion();

            // Vérifier si le stage existe
            $checkQuery = $db->prepare('SELECT id_stage FROM stage WHERE id_stage = :id');
            $checkQuery->execute(['id' => $id]);
            if ($checkQuery->rowCount() == 0) {
                echo "Stage introuvable.";
                return false;
            }

            // Préparer la déclaration de mise à jour
            $query = $db->prepare(
                'UPDATE stage SET 
                    nom_societe = :nom_societe,
                    type = :type,
                    duration = :duration,
                    email = :email,
                    speciality = :speciality,
                    documents = :documents
                WHERE id_stage = :id'
            );

            // Exécuter la requête avec les paramètres
            $query->execute([
                'id' => $id,
                'nom_societe' => $stage->getNomStage(),
                'type' => $stage->getType(),
                'duration' => $stage->getDuration(),
                'email' => $stage->getEmail(),
                'speciality' => $stage->getSpeciality(),
                'documents' => $stage->getDocuments()
            ]);

            echo "Stage mis à jour avec succès.";
            return true;
        } catch (PDOException $e) {
            error_log('Error updating stage: ' . $e->getMessage());
            echo "Erreur lors de la mise à jour du stage.";
            return false;
        }
    }

    // Afficher les détails d'un stage
    public function showStage($id) {
        if (!is_numeric($id) || $id <= 0) {
            echo "Invalid ID.";
            return null;
        }

        $sql = "SELECT * FROM stage WHERE id_stage = :id";
        $db = config::getConnexion();

        try {
            // Préparer et exécuter la requête
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC); // Retourner un seul enregistrement sous forme de tableau associatif
        } catch (Exception $e) {
            error_log('Error fetching stage: ' . $e->getMessage());
            return null;
        }
    }
}
 */


>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091

 require_once(__DIR__ . '/../config.php');
 require_once(__DIR__ . '/../Model/stage.php');
 
 class StageController
 {
     // Liste des stages
     public function listStage() {
         $sql = "SELECT * FROM stage";
         $db = config::getConnexion();
         try {
             $stmt = $db->query($sql);
             return $stmt->fetchAll();
         } catch (PDOException $e) {
             echo "Erreur: " . $e->getMessage();
             return [];
         }
     }
 
     // Suppression d'un stage
     public function deleteStage($id) {
         if (!is_numeric($id) || $id <= 0) {
             echo "ID invalide.<br>";
             return false; // Return false on invalid ID
         }
 
         $sql = "DELETE FROM stage WHERE id_stage = :id";
         $db = config::getConnexion();
         $req = $db->prepare($sql);
         $req->bindValue(':id', $id, PDO::PARAM_INT);
 
         try {
             $req->execute();
             echo "Stage supprimé avec succès.<br>"; // Message de débogage
             return true; // Return true on success
         } catch (PDOException $e) {
             // More specific error handling for database issues
             error_log('Erreur lors de la suppression du stage: ' . $e->getMessage());
             echo "Erreur lors de la suppression du stage: " . $e->getMessage() . "<br>"; // Message de débogage
             return false; // Return false on error
         }
     }
 
     // Ajout d'un stage
     public function addStage($stage) {
         // Vérifiez si l'id_societe est valide
         if (!is_numeric($stage->getIdSociete()) || $stage->getIdSociete() <= 0) {
             echo "ID de société invalide.<br>";
             return false;
         }
 
         $sql = "INSERT INTO stage (type, duration, email, speciality, documents, id_societe)
                 VALUES (:type, :duration, :email, :speciality, :documents, :id_societe)";
         $db = config::getConnexion();
 
         try {
             $stmt = $db->prepare($sql);
             $speciality = implode(",", $stage->getSpeciality()); // Convertir les spécialités en chaîne de caractères
 
             // Exécuter la requête avec les valeurs de l'objet $stage
             $stmt->execute([
                 'type' => $stage->getType(),
                 'duration' => $stage->getDuration(),
                 'email' => $stage->getEmail(),
                 'speciality' => $speciality,
                 'documents' => $stage->getDocuments(),
                 'id_societe' => $stage->getIdSociete()
             ]);
 
             return true;
         } catch (PDOException $e) {
             error_log('Erreur lors de l\'ajout du stage: ' . $e->getMessage());
             echo "Erreur: " . $e->getMessage();
             return false;
         }
     }
 
     // Mise à jour d'un stage
     public function updateStage($stage, $id) {
         if (!is_numeric($id) || $id <= 0) {
             echo "ID invalide.";
             return false;
         }
 
         try {
             $db = config::getConnexion();
 
             // Vérifier si le stage existe
             $checkQuery = $db->prepare('SELECT id_stage FROM stage WHERE id_stage = :id');
             $checkQuery->execute(['id' => $id]);
             if ($checkQuery->rowCount() == 0) {
                 echo "Stage introuvable.";
                 return false;
             }
 
             // Préparer la déclaration de mise à jour
             $query = $db->prepare(
                 'UPDATE stage SET 
                     type = :type,
                     duration = :duration,
                     email = :email,
                     speciality = :speciality,
                     documents = :documents,
                     id_societe = :id_societe
                 WHERE id_stage = :id'
             );
 
             // Exécuter la requête avec les paramètres
             $query->execute([
                 'id' => $id,
                 'type' => $stage->getType(),
                 'duration' => $stage->getDuration(),
                 'email' => $stage->getEmail(),
                 'speciality' => $stage->getSpeciality(),
                 'documents' => $stage->getDocuments(),
                 'id_societe' => $stage->getIdSociete()
             ]);
 
             echo "Stage mis à jour avec succès.";
             return true;
         } catch (PDOException $e) {
             error_log('Erreur lors de la mise à jour du stage: ' . $e->getMessage());
             echo "Erreur lors de la mise à jour du stage.";
             return false;
         }
     }
 
     // Afficher les détails d'un stage
     public function showStage($id) {
         if (!is_numeric($id) || $id <= 0) {
             echo "ID invalide.";
             return null;
         }
 
         $sql = "SELECT * FROM stage WHERE id_stage = :id";
         $db = config::getConnexion();
 
         try {
             // Préparer et exécuter la requête
             $query = $db->prepare($sql);
             $query->bindValue(':id', $id, PDO::PARAM_INT);
             $query->execute();
 
             return $query->fetch(PDO::FETCH_ASSOC); // Retourner un seul enregistrement sous forme de tableau associatif
         } catch (Exception $e) {
             error_log('Erreur lors de la récupération du stage: ' . $e->getMessage());
             return null;
         }
     }
 }
<<<<<<< HEAD
  */
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7



  require_once(__DIR__ . '/../config.php');
  require_once(__DIR__ . '/../Model/stage.php');
  
  class StageController
  {
      // Liste des stages
      public function listStage() {
          $sql = "SELECT * FROM stage";
          $db = config::getConnexion();
          try {
              $stmt = $db->query($sql);
              return $stmt->fetchAll();
          } catch (PDOException $e) {
              echo "Erreur: " . $e->getMessage();
              return [];
          }
      }
  
      // Suppression d'un stage
      public function deleteStage($id) {
          if (!is_numeric($id) || $id <= 0) {
              echo "ID invalide.<br>";
              return false; // Return false on invalid ID
          }
  
          $sql = "DELETE FROM stage WHERE id_stage = :id";
          $db = config::getConnexion();
          $req = $db->prepare($sql);
          $req->bindValue(':id', $id, PDO::PARAM_INT);
  
          try {
              $req->execute();
              echo "Stage supprimé avec succès.<br>"; // Message de débogage
              return true; // Return true on success
          } catch (PDOException $e) {
              // More specific error handling for database issues
              error_log('Erreur lors de la suppression du stage: ' . $e->getMessage());
              echo "Erreur lors de la suppression du stage: " . $e->getMessage() . "<br>"; // Message de débogage
              return false; // Return false on error
          }
      }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
      public function addStage($stage) {
        // Vérifiez si l'id_societe est valide
        if (!is_numeric($stage->getIdSociete()) || $stage->getIdSociete() <= 0) {
            echo "ID de société invalide.<br>";
            return false;
        }

        $sql = "INSERT INTO stage (nom_stage, type, duration, email, speciality, documents, id_societe)
                VALUES (:nom_stage, :type, :duration, :email, :speciality, :documents, :id_societe)";
        $db = config::getConnexion();

        try {
            $stmt = $db->prepare($sql);
            $speciality = implode(",", $stage->getSpeciality());  // Convertir les spécialités en chaîne de caractères

            // Exécuter la requête avec les valeurs de l'objet $stage
            $stmt->execute([
                'nom_stage' => $stage->getNomStage(),
                'type' => $stage->getType(),
                'duration' => $stage->getDuration(),
                'email' => $stage->getEmail(),
                'speciality' => $speciality,
                'documents' => $stage->getDocuments(),
                'id_societe' => $stage->getIdSociete()
            ]);

            
            return true;
        } catch (PDOException $e) {
            error_log('Erreur lors de l\'ajout du stage: ' . $e->getMessage());
            echo "Erreur: " . $e->getMessage();
            return false;
        }
    }

    public function getLatestStage() {
        try {
            // Récupérer la connexion via la méthode statique de la classe config
            $db = config::getConnexion(); 
    
            // Exécution de la requête pour récupérer le dernier stage en fonction de l'ID
            $sql = "SELECT * FROM stage ORDER BY id_stage DESC LIMIT 1";
            $stmt = $db->query($sql);
    
            // Vérifie si un stage a été trouvé
            $latestStage = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($latestStage) {
                return $latestStage; // Retourne le dernier stage ajouté
            } else {
                return null; // Aucun stage trouvé
            }
        } catch (PDOException $e) {
            // Gestion des erreurs de la base de données
            echo "Erreur lors de la récupération du dernier stage: " . $e->getMessage();
            return null; // En cas d'erreur, retourne null
        }
    }
    
    
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
  
      // Ajout d'un stage
      public function addStage($stage) {
          // Vérifiez si l'id_societe est valide
          if (!is_numeric($stage->getIdSociete()) || $stage->getIdSociete() <= 0) {
              echo "ID de société invalide.<br>";
              return false;
          }
  
          $sql = "INSERT INTO stage (nom_stage, type, duration, email, speciality, documents, id_societe)
                  VALUES (:nom_stage, :type, :duration, :email, :speciality, :documents, :id_societe)";
          $db = config::getConnexion();
  
          try {
              $stmt = $db->prepare($sql);
              $speciality = implode(",", $stage->getSpeciality()); // Convertir les spécialités en chaîne de caractères
  
              // Exécuter la requête avec les valeurs de l'objet $stage
              $stmt->execute([
                  'nom_stage' => $stage->getNomStage(), // Ajout du nom du stage
                  'type' => $stage->getType(),
                  'duration' => $stage->getDuration(),
                  'email' => $stage->getEmail(),
                  'speciality' => $speciality,
                  'documents' => $stage->getDocuments(),
                  'id_societe' => $stage->getIdSociete()
              ]);
  
              return true;
          } catch (PDOException $e) {
              error_log('Erreur lors de l\'ajout du stage: ' . $e->getMessage());
              echo "Erreur: " . $e->getMessage();
              return false;
          }
      }
  
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
      // Mise à jour d'un stage
      public function updateStage($stage, $id) {
          if (!is_numeric($id) || $id <= 0) {
              echo "ID invalide.";
              return false;
          }
      
          try {
              // Connexion à la base de données
              $db = config::getConnexion();
      
              // Vérifier si le stage existe
              $checkQuery = $db->prepare('SELECT id_stage FROM stage WHERE id_stage = :id');
              $checkQuery->execute(['id' => $id]);
              if ($checkQuery->rowCount() == 0) {
                  echo "Stage introuvable.";
                  return false;
              }
      
              // Préparer la déclaration de mise à jour sans les commentaires
              $query = $db->prepare(
                  'UPDATE stage SET 
                      nom_stage = :nom_stage,
                      type = :type,
                      duration = :duration,
                      email = :email,
                      speciality = :speciality,
                      documents = :documents,
                      id_societe = :id_societe
                  WHERE id_stage = :id'
              );
      
              // Exécuter la requête avec les paramètres
              $query->execute([
                  'id' => $id,
                  'nom_stage' => $stage->getNomStage(),
                  'type' => $stage->getType(),
                  'duration' => $stage->getDuration(),
                  'email' => $stage->getEmail(),
                  'speciality' => $stage->getSpeciality(),
                  'documents' => $stage->getDocuments(),
                  'id_societe' => $stage->getIdSociete()
              ]);
      
              // Vérification du succès de la mise à jour
              if ($query->rowCount() > 0) {
                  echo "Stage mis à jour avec succès.";
                  return true;
              } else {
                  echo "Aucune modification apportée, le stage est déjà à jour.";
                  return false;
              }
          } catch (PDOException $e) {
              // Journaliser l'erreur pour les administrateurs
              error_log('Erreur lors de la mise à jour du stage: ' . $e->getMessage());
              echo "Erreur lors de la mise à jour du stage.";
              return false;
          }
      }
      
  
      // Afficher les détails d'un stage
      public function showStage($id) {
          if (!is_numeric($id) || $id <= 0) {
              echo "ID invalide.";
              return null;
          }
  
          $sql = "SELECT * FROM stage WHERE id_stage = :id";
          $db = config::getConnexion();
  
          try {
              // Préparer et exécuter la requête
              $query = $db->prepare($sql);
              $query->bindValue(':id', $id, PDO::PARAM_INT);
              $query->execute();
  
              return $query->fetch(PDO::FETCH_ASSOC); // Retourner un seul enregistrement sous forme de tableau associatif
          } catch (Exception $e) {
              error_log('Erreur lors de la récupération du stage: ' . $e->getMessage());
              return null;
          }
      }
  
  
      public function listStagesWithPagination($limit, $offset) {
          $sql = "SELECT * FROM stage LIMIT :limit OFFSET :offset";
          $db = config::getConnexion();
          try {
              $stmt = $db->prepare($sql);
              $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
              $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
              $stmt->execute();
              return $stmt->fetchAll();
          } catch (PDOException $e) {
              echo "Erreur: " . $e->getMessage();
              return [];
          }
      }
  
      public function countStages() {
          $sql = "SELECT COUNT(*) as count FROM stage";
          $db = config::getConnexion();
          try {
              $stmt = $db->query($sql);
              $result = $stmt->fetch();
              return $result['count'];
          } catch (PDOException $e) {
              echo "Erreur: " . $e->getMessage();
              return 0;
          }
      }
  
  
      public function getCandidaturesForStage($id_stage) {
          $sql = "SELECT * FROM candidatures WHERE id_stage = :id_stage";
          $db = config::getConnexion();
          
          try {
              $stmt = $db->prepare($sql);
              $stmt->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
              $stmt->execute();
              return $stmt->fetchAll(); // Retourne toutes les candidatures associées à ce stage
          } catch (PDOException $e) {
              echo "Erreur: " . $e->getMessage();
              return [];
          }
      }
      public function listStagesBySociete($societe_id, $limit, $offset) {
        $sql = "SELECT * FROM stage WHERE id_societe = :id_societe LIMIT :limit OFFSET :offset";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_societe', $societe_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }
    
    public function countStagesBySociete($societe_id) {
        $sql = "SELECT COUNT(*) as count FROM stage WHERE id_societe = :id_societe";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_societe', $societe_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return 0;
        }
    }
    
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
        // Ajouter cette méthode pour gérer la recherche et la pagination
        public function searchAndPaginate($searchTerm = '', $limit, $offset) {
            $db = config::getConnexion();
            $sql = "SELECT * FROM stage WHERE nom_stage LIKE :searchTerm LIMIT :limit OFFSET :offset";
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
            $sql = "SELECT COUNT(*) as count FROM stage WHERE nom_stage LIKE :searchTerm";
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
    
    
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
    
  }
  
  ?>
  


<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
 
 ?>
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
 