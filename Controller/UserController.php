<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/User.php');

class UserController
{
    public function listUser()
    {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addUser($user, $origin) {
        if ($origin == 'front') {
            $role = 2;
        } else {
            $role = $user->getRole();
        }
    
        $sql = "INSERT INTO users 
                VALUES (NULL, :nom, :prenom, :email, :password, :role, :date_creation)";
        $db = config::getConnexion();
        try {
            var_dump($user);
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $role, 
                'date_creation' => $user->getCreationDate()->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function updateUser($user, $id)
    {   
    try {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE users SET 
                nom = :nom,
                prenom = :prenom,
                email = :email,
                password = :password,
                role = :role
            WHERE id = :id'
        );

        $query->execute([
            'id' => $id,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(), 
            'password' => $user->getPassword(),
            'role'=>$user->getRole()
        ]);

        echo $query->rowCount() . " records UPDATED successfully <br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }
}


    function showUser($id)
    {
        $sql = "SELECT * from users where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $user = $query->fetch();
            return $user;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getUserPassword($userId) {
        // Your database query to get the password for a given user
        $query = "SELECT password FROM users WHERE id = :userId";
        $db = config::getConnexion();
        
        // Prepare and execute the query
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the result and return the password
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Return the password if found, otherwise return null or an empty string
        return $result ? $result['password'] : '';
    }
    


}
    