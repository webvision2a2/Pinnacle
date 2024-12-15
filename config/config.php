<?php
// config.php

/**
 * Database class for establishing a connection using PDO.
 */
class Database {
    private string $host = 'localhost'; // Database host
    private string $dbname = 'prjtweb'; // Database name
    private string $username = 'root'; // Database username
    private string $password = ''; // Database password
    private ?PDO $connection = null;

    /**
     * Establish a database connection using PDO.
     *
     * @return PDO|null Returns the PDO connection object or null if connection fails.
     * @throws Exception If the connection fails.
     */
    public function connect(): ?PDO {
        if ($this->connection === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            try {
                $this->connection = new PDO($dsn, $this->username, $this->password);
                // Set the PDO error mode to exception
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Connection failed: " . $e->getMessage());
            }
        }
        return $this->connection; // Return the connection object
    }

    /**
     * Close the database connection.
     */
    public function close(): void {
        $this->connection = null; // Close the connection by setting it to null
    }
}
?>