<?php
class Database
{
    private static $instance = null;
    private $connection = null;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'bwb';
        $user = 'root';
        $pass = 'youshallnotpass';
        $port = '3306';
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new Exception(sprintf(
                "Connection failed: %s (Error code: %s)",
                $e->getMessage(),
                $e->getCode()
            ));
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Add these new methods
    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}