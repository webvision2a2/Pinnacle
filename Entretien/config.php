<?php
class Config
{
    private static $pdo = null;
    public static function getConnexion()
    {
        if (self::$pdo === null) {
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";  // In XAMPP, the default password is empty, change it if necessary
            $dbname = "entretien";  // Replace with your actual database name

            try {
                // PDO connection string with error handling
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // Set attributes for error handling and fetch mode
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                // Optionally log the success message, but avoid printing it in production
                // echo "Connected successfully"; // For debugging purposes only
            } catch (Exception $e) {
                // If the connection fails, display the error message
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
// Call the method to establish the connection (you can remove this line if it's only for class definition)
Config::getConnexion();
?>
