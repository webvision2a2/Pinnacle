<!-- <?php
/* include_once '../Model/config_db/config.php';
class connection{
    private $db;

    public function __construct($connect){
        $this->db=$connect;
    }

    public function connect(){
        if($this->db){
            echo 'welcome to database';
        }else{
            echo 'probleme';
        }
    }

    public function insert(){
        
    }
}

$test = new connection($connect);
$test->connect(); */

?> -->

<?php
class config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gestion_u";
            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                echo "Connected to the database successfully!";
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

config::getConnexion();
?>
