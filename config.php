
<?php

class config {
    private $host = 'localhost';
    private $dbname = 'web';
    private $username = 'root';
    private $password = '';
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getConnexion() {
        $instance = new self();
        return $instance->pdo;
    }
}

// Initialisation de la connexion pour qu'elle soit disponible dans index.php
$db = new config();
$pdo = $db->pdo;
?>




