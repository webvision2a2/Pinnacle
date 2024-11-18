<?php
$host = 'localhost'; 
$dbname = 'web'; 
$username = 'root'; 
$password = '';

class Database {
    private $host = 'localhost'; 
    private $dbname = 'prjtweb'; 
    private $username = 'root'; 
    private $password = ''; 
    private $connection;
    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function close() {
        $this->connection = null; 
    }
}
