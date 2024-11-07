<?php
class Database {
    private static $instance = null;
    private $connection = null;
    
    private function __construct() {
        $host = '127.0.0.1';  // Change from 'localhost' to '127.0.0.1'
        $db   = 'bwb';
        $user = 'root';
        $pass = 'youshallnotpass';
        $port = '3306';
        
        try {
            $this->connection = new PDO(
                "mysql:host=$host;port=$port;dbname=$db",
                $user,
                $pass
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}