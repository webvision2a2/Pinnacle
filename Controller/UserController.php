<?php
require_once __DIR__ . '/../config_zeineb.php';
include(__DIR__ . '/../Model/User.php');
include(__DIR__ . '/ProfileController.php');

require_once __DIR__ . '../../vendor/autoload.php';


require_once __DIR__ . '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '../../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UserController
{
    /* public function listUser()
    {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    } */

    public function listUser()
    {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(PDO::FETCH_ASSOC);  // This fetches the result as an associative array
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }


    function addUser($user, $origin) {
        if ($origin == 'front') {
            $role = 2;
            $verification = 0;
        } else {
            $role = $user->getRole();
            $verification = 1;
        }

        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO users 
            (nom, prenom, email, password, role, verification, face_id) 
            VALUES (:nom, :prenom, :email, :password, :role, :verification, :face_id)";
        $db = config::getConnexion();
        try {
            var_dump($user);
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'password' => $hashedPassword,
                'role' => $role, 
                'verification' => $verification,
                'face_id' => $user->getFaceId()
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
    

    function deleteUser($id)
    {
        $profileController = new ProfileController();
        $profileController->deleteProfile($id); 

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

        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $query = $db->prepare(
            'UPDATE users SET 
                nom = :nom,
                prenom = :prenom,
                email = :email,
                password = :password,
                role = :role,
                verification = :verification
            WHERE id = :id'
        );

        $query->execute([
            'id' => $id,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(), 
            'password' => $hashedPassword,
            'role'=>$user->getRole(),
            'verification' => $user->getVerification()
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
        $query = "SELECT password FROM users WHERE id = :userId";
        $db = config::getConnexion();
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['password'] : '';
    }

    /* public function searchUsersByEmail($keyword)
    {
        $db = config::getConnexion();
        try {
            // Search users based on email containing the keyword
            $sql = "SELECT * FROM users WHERE email LIKE :keyword";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            $stmt->execute();
            
            // Fetch all results
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $users; // Return the search results
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } */

    public function searchUsersByEmail($keyword, $limit, $offset)
    {
        $db = config::getConnexion();
        try {
            // Search users based on email containing the keyword with pagination
            $sql = "SELECT * FROM users WHERE email LIKE :keyword LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            // Fetch the paginated results
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $users; // Return the search results
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }



    public function getUsersPaginated($limit, $offset)
    {
        $db = config::getConnexion();
        $query = "SELECT * FROM users LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchUsersWithFilters($keyword, $limit, $offset, $sort_order, $role_filter)
{
    $db = config::getConnexion();
    try {
        $query = "SELECT * FROM users WHERE email LIKE :keyword";
        
        // Add filtering by role if specified
        if (!empty($role_filter)) {
            $query .= " AND role = :role_filter";
        }
        
        // Add sorting and pagination
        $query .= " ORDER BY date_creation $sort_order LIMIT :limit OFFSET :offset";
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        if (!empty($role_filter)) {
            $stmt->bindValue(':role_filter', $role_filter, PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}



    public function getUsersPaginatedWithFilters($limit, $offset, $sort_order, $role_filter)
    {
        $db = config::getConnexion();
        try {
            $query = "SELECT * FROM users";
            
            // Add filtering by role if specified
            $conditions = [];
            if (!empty($role_filter)) {
                $conditions[] = "role = :role_filter";
            }
            
            // Build WHERE clause if any conditions exist
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            
            // Add sorting and pagination
            $query .= " ORDER BY date_creation $sort_order LIMIT :limit OFFSET :offset";
            
            $stmt = $db->prepare($query);
            
            // Bind parameters for filtering and pagination
            if (!empty($role_filter)) {
                $stmt->bindValue(':role_filter', $role_filter, PDO::PARAM_INT);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }



    public function envoyerEmail(string $to): void
    {
        $mail = new PHPMailer(true);

        try {
         
            $mail->SMTPDebug = 3; 
            $mail->Debugoutput = 'html';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'doghri.zeineb24@gmail.com'; //email mteek
            $mail->Password = 'jqdi bkac bizg zktg';//votre mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;

          
            $mail->setFrom('doghri.zeineb24@gmail.com', 'systeme de gestion');
            $mail->addAddress($to); 

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Alech baatht il mail';
            $mail->Body = 'chnya fi west il mail'; // Contenu HTML


         
            $mail->send();
            echo 'Email envoyé avec succès.';
            error_log("Email envoyé avec succès à $to pour le sujet : 'mail'.");
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo);
            echo "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
        }
    }


    

    public function verifyEmail($token)
    {
        $db = config::getConnexion();
        $verification_valid = 1;

        try {
            // Step 1: Check if the token exists and is still valid
            $sql = "SELECT email FROM password_resets WHERE token = :token AND expires_at >= NOW()";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userEmail) {
                // Step 2: Update the user's verification status
                $sqlUpdate = "UPDATE users SET verification = :verification WHERE email = :email";
                $stmtUpdate = $db->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':verification', $verification_valid, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':email', $userEmail['email'], PDO::PARAM_STR);
                $stmtUpdate->execute();

                // Step 3: Delete the token from the password_resets table
                $sqlDelete = "DELETE FROM password_resets WHERE email = :email";
                $stmtDelete = $db->prepare($sqlDelete);
                $stmtDelete->bindParam(':email', $userEmail['email'], PDO::PARAM_STR);
                $stmtDelete->execute();

                return true;
            } else {
                // No valid token found
                return false;
            }
        } catch (PDOException $e) {
            // Log the error for debugging purposes
            error_log("Error in verifyEmail: " . $e->getMessage());
            return false;
        }
    }




    public function storeOpt($email, $otp, $expires) {
        $db = config::getConnexion();
        try {
            $sql = "INSERT INTO user_otps (email, otp, expires_at) VALUES (:email, :otp, :expires_at)
                    ON DUPLICATE KEY UPDATE otp = :otp, expires_at = :expires_at";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':otp', $otp);
            $stmt->bindParam(':expires_at', $expires);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function storePasswordResetToken($email, $token, $expires) {
        $db = config::getConnexion();
        try {
            $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at)
                    ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires_at', $expires);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function resetPassword($token, $newPassword) {
        $db = config::getConnexion();
        try {
            $sql = "SELECT email FROM password_resets WHERE token = :token AND expires_at >= NOW()";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($userEmail) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sqlUpdate = "UPDATE users SET password = :password WHERE email = :email";
                $stmtUpdate = $db->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':password', $hashedPassword);
                $stmtUpdate->bindParam(':email', $userEmail['email']);
                $stmtUpdate->execute();

                $sqlDelete = "DELETE FROM password_resets WHERE email = :email";
                $stmtDelete = $db->prepare($sqlDelete);
                $stmtDelete->bindParam(':email', $userEmail['email']);
                $stmtDelete->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Optionally, log this error
            return false;
        }
    }

    public function isEmailExists($email) {
        $db = config::getConnexion();
        // Prepare the SQL query to search for the email
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";

        // Prepare the statement
        $stmt = $db->prepare($sql);

        // Bind the email parameter
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Get the count result
        $count = $stmt->fetchColumn();

        // Return true if email exists, false if it doesn't
        return $count > 0;
    }

    
    public function getCurrentPasswordHashByToken($token) {
        $db = config::getConnexion();
        try{
            $stmt = $db->prepare("SELECT users.password FROM users JOIN password_resets ON users.email = password_resets.email WHERE password_resets.token = ?");
            $stmt->execute([$token]);
            $result = $stmt->fetch();
            return $result ? $result['password'] : null;
        }catch(PDOException $e){
            error_log("Database error in getCurrentPasswordHashByToken: " . $e->getMessage());
            return null;  
        }
    }

    public function getUserByFaceId($faceId) {
        $sql = "SELECT * FROM users WHERE face_id = :face_id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':face_id', $faceId, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserByFaceId: " . $e->getMessage());
            return null;
        }
    }

    function generateCode($length){
		$chars = "vwxyzABCD02789";
		$code = ""; 
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length){ 
			$code .= $chars[mt_rand(0,$clen)];
		}
		return $code;
    }

    function insertData($data) {
        $db = config::getConnexion();

        
        // Check if the user already exists based on the email
         $checkUser = $db->prepare("SELECT * FROM users WHERE email=:email");
        $checkUser->execute(array('email' => $data['email']));
        $info = $checkUser->fetch(PDO::FETCH_ASSOC);
        
        // If the user doesn't exist, insert new user data
        if (!$info) {
            // Generate a random password for Google login, as users login using their Google credentials
            $password = $this->generateCode(5);  // You can leave this as it is or modify it to null if not needed
            $role = 2;
            $verification = 1;
            
            // Insert new user into the database
            $insertNewUser = $db->prepare("INSERT INTO users (nom, prenom, email, password, role, verification) 
                                          VALUES (:nom, :prenom, :email, :password, :role, :verification)");
            $insertNewUser->execute([
                ':nom' => $data["givenName"],            // First name
                ':prenom' => $data["familyName"],        // Last name
                ':email' => $data["email"],              // User's email
                ':password' => $password,                // Google login doesn't require a password, but you can set one
                ':role' => $role,                        // Default role, can be 'user', 'admin', or any other role as needed
                ':verification' => $verification         // Mark user as verified or set to null if needed
            ]);
            
            // Check if user inserted successfully
            if ($insertNewUser) {
                // Start the session
                session_start();

                // Store user information in the session
                $_SESSION["loggedin"] = true;
                $_SESSION['id'] = $db->lastInsertId();  // Store the user's unique ID
                $_SESSION['nom'] = $data['familyName'];  // Last name
                $_SESSION['prenom'] = $data['givenName'];  // First name
                $_SESSION['role'] = $role;             // Optionally store the user's role
                $_SESSION['email'] = $data['email'];   // Store the user's email
                $_SESSION['verification'] = $verification; // Verification status

                $profileController = new ProfileController();
                $profileController->createProfile($_SESSION['id']);
                

                // Redirect to homepage or dashboard
                header('Location: Template/index.php');
                exit();
            }else {
                return "Error inserting user!";
            }
        } else {
            // If the user already exists, set session variables and redirect
            session_start();

            // Store the necessary user information in the session
            $_SESSION["loggedin"] = true;
            $_SESSION['id'] = $info['id'];          // Store the user's ID
            $_SESSION['nom'] = $info['nom'];  // Last name
            $_SESSION['prenom'] = $info['prenom'];  // First name
            $_SESSION['role'] = $info['role'];      // Optionally store the user's role
            $_SESSION['email'] = $info['email'];    // Store the user's email
            $_SESSION['verification'] = $info['verification']; // Store verification status if applicable
            

            // Redirect to the homepage or dashboard
            header('Location: Template/index.php');
            exit();

        }
    }
    


}

?>
    