<?php

require_once __DIR__ . '/../config.php';
include(__DIR__ . '/../Model/Profile.php');
class ProfileController
{
    public function listProfile()
    {
        $sql = "SELECT * FROM profiles";
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function createProfile($userId) {
        $sql = "INSERT INTO profiles (user_id, domaine, occupation, age, telephone, photo_profil) 
                VALUES (:user_id, :domaine, :occupation, :age, :telephone, :photo_profil)";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([
                'user_id' => $userId,
                'domaine' => 'Non spécifié',      
                'occupation' => 'Non spécifié',       
                'age' => 0,                       
                'telephone' => 'Non spécifié',    
                'photo_profil' => 'img/blank-profile-picture-973460_1280.webp' 
            ]);
        } catch (PDOException $e) {
            die('SQL Error: ' . $e->getMessage());
        }        
    }
    

    public function getProfileByUserId($userId)
    {
        $sql = "SELECT * FROM profiles WHERE user_id = :user_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function updateProfile($id, $profile)
    {
        $sql = "UPDATE profiles 
                SET id = :id, 
                domaine = :domaine, 
                occupation = :occupation, 
                age = :age, 
                telephone = :telephone, 
                photo_profil = :photo_profil
                WHERE user_id = :user_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $profile->getId(),
                'user_id' => $id,
                'domaine' => $profile->getDomaine(),
                'occupation' => $profile->getOccupation(),
                'age' => $profile->getAge(),
                'telephone' => $profile->getTelephone(),
                'photo_profil' => $profile->getProfilePicture()
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    





    function showProfile($id)
    {
        $sql = "SELECT * from profiles where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $profile = $query->fetch();
            return $profile;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function deleteProfile($userId)
    {
        $sql = "DELETE FROM profiles WHERE user_id = :user_id";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);

        try {
            $stmt->execute();
            echo "Profile deleted successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

}
?>