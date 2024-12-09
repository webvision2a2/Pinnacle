<?php
class config {
    private static $pdo = null;

    public static function getConnexion() {
        if (self::$pdo === null) {
            $servername = "localhost";
            $dbname = "evenement";
            $username = "root";
            $password = "";

            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
