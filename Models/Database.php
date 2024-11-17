<?php
// Models/Database.php

class Database {
    private $host = 'localhost'; // Database host
    private $dbname = 'prjtweb'; // Database name
    private $username = 'root'; // Database username
    private $password = ''; // Database password
    private $connection;

    // Method to establish a database connection using PDO
    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            // Set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection; // Return the connection object
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Optional: Method to close the connection
    public function close() {
        $this->connection = null; // Close the connection by setting it to null
    }
}